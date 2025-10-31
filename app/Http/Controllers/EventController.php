<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\EventReview;
use App\Models\Ticket;
use App\Services\QrCodeService;
use App\Support\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class EventController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->middleware('auth');
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Generate a shareable link (and slug) for an event if missing, for organizers.
     */
    public function generateShareLink(Event $event)
    {
        $this->authorize('update', $event);
        $currentUser = Auth::user();
        $devBypass = app()->environment(['local','development']);
        $bypassUsers = collect(explode(',', (string) env('PROMO_BYPASS_USER_IDS', '')))
            ->filter(fn($v) => $v !== '')
            ->map(fn($v) => (int) trim((string) $v))
            ->all();
        $hasBypass = $currentUser && in_array((int) $currentUser->id, $bypassUsers, true);
        if (!$currentUser || (!($currentUser->isAdmin() || in_array(($currentUser->subscription_plan ?? 'basic'), ['premium','pro'], true) || $devBypass || $hasBypass))) {
            return back()->with('error', 'Fonctionnalité réservée aux abonnements Premium et Pro.');
        }

        if (!$event->slug) {
            $base = Str::slug($event->title);
            $slug = $base;
            $i = 2;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $event->slug = $slug;
        }

        $link = route('promo.show', ['slug' => $event->slug]);
        $orgId = $event->organizer_id ?: (auth()->check() ? auth()->id() : null);
        if ($orgId) {
            $link .= (str_contains($link, '?') ? '&' : '?') . 'ref=' . urlencode('org-' . $orgId);
        }

        $event->shareable_link = $link;
        $event->save();

        return back()->with('success', 'Lien de promotion généré.');
    }

    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::upcoming()
            ->withCount('registrations')
            ->orderBy('start_date')
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $this->authorize('create', Event::class);
        return view('events.create', [
            'currencies' => Currency::all(),
            'defaultCurrency' => config('currency.default', 'EUR'),
            'categories' => [
                'concert' => 'Concert',
                'conference' => 'Conférence',
                'formation' => 'Formation',
                'atelier' => 'Atelier',
                'sport' => 'Sport',
                'festival' => 'Festival',
                'meetup' => 'Meetup',
                'webinar' => 'Webinar',
                'autre' => 'Autre',
            ],
        ]);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        // Validation des données du formulaire (avec nouveaux champs)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'google_maps_url' => 'nullable|url|max:255',
            'start_date' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime('today')) {
                        $fail("La date de début doit être aujourd'hui ou une date future.");
                    }
                },
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) <= strtotime($request->start_date)) {
                        $fail("La date de fin doit être postérieure à la date de début.");
                    }
                },
            ],
            'daily_start_time' => 'nullable|date_format:H:i',
            'daily_end_time' => 'nullable|date_format:H:i',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_capacity_unlimited' => 'nullable|boolean',
            'capacity' => ['nullable','integer','min:1','required_unless:is_capacity_unlimited,1'],
            'payment_type' => ['required', Rule::in(['free','paid'])],
            'price' => 'nullable|numeric|min:0',
            'currency' => ['required', 'string', 'size:3', Rule::in(array_keys(Currency::all()))],
            'allow_payment_numeric' => 'nullable|boolean',
            'allow_payment_physical' => 'nullable|boolean',
            'allow_ticket_transfer' => 'nullable|boolean',
            'is_restricted_18' => 'nullable|boolean',
            'is_interactive' => 'nullable|boolean',
            'interactive_public' => 'nullable|boolean',
            'interactive_starts_at' => 'nullable|date',
            'interactive_ends_at' => 'nullable|date|after_or_equal:interactive_starts_at',
        ], [
            'start_date.after' => 'La date de début doit être une date future.',
            'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
            'capacity.required_unless' => 'Indiquez la capacité quand l\'option illimitée n\'est pas cochée.',
        ]);

        // Pour les événements payants, exiger au moins une méthode de paiement
        if ($validated['payment_type'] === 'paid' && !$request->boolean('allow_payment_numeric') && !$request->boolean('allow_payment_physical')) {
            return back()->withErrors(['allow_payment_numeric' => 'Au moins une méthode de paiement doit être activée pour un événement payant.'])->withInput();
        }

        // Limites selon l'abonnement de l'organisateur
        $currentUser = Auth::user();
        $bypassUsers = collect(explode(',', (string) env('PROMO_BYPASS_USER_IDS', '')))
            ->filter(fn($v) => $v !== '')
            ->map(fn($v) => (int) trim((string) $v))
            ->all();
        $hasBypass = $currentUser && in_array((int) $currentUser->id, $bypassUsers, true);
        if ($currentUser && $currentUser->isOrganizer()) {
            $plan = $currentUser->subscription_plan ?: 'basic';
            $planCaps = [
                'basic' => ['max_capacity' => 50, 'max_events_per_month' => 10],
                'premium' => ['max_capacity' => 150, 'max_events_per_month' => 30],
                'pro' => ['max_capacity' => null, 'max_events_per_month' => 100],
            ];
            $caps = $planCaps[$plan] ?? $planCaps['basic'];

            // Capacité par événement
            if (!is_null($caps['max_capacity']) && (int) $validated['capacity'] > (int) $caps['max_capacity']) {
                return back()
                    ->withErrors(['capacity' => "Capacité maximale autorisée pour l'offre " . ucfirst($plan) . " : " . $caps['max_capacity'] . " places par événement."])
                    ->withInput();
            }

            // Nombre d'événements par mois
            $createdThisMonth = Event::where('organizer_id', $currentUser->id)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count();
            if ((int) $createdThisMonth >= (int) $caps['max_events_per_month']) {
                return back()
                    ->with('error', "Vous avez atteint la limite mensuelle d'événements pour l'offre " . ucfirst($plan) . " (" . $caps['max_events_per_month'] . " événements par mois).")
                    ->withInput();
            }
        }

        // Traitement de l'image de couverture si elle est fournie
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('events/cover_images', 'public');
            $validated['cover_image'] = $path;
        }
        
        // Génération du slug unique et du lien partageable
        $slugBase = Str::slug($validated['title']);
        $slug = $slugBase;
        $i = 2;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $i++;
        }
        $shareLink = route('promo.show', ['slug' => $slug]);
        if (Auth::check()) {
            $shareLink .= (str_contains($shareLink, '?') ? '&' : '?') . 'ref=' . urlencode('org-' . Auth::id());
        }

        // Déterminer prix et capacité selon les choix
        $isUnlimited = $request->boolean('is_capacity_unlimited');
        $capacity = $isUnlimited ? (int) ($validated['capacity'] ?? 0) : (int) $validated['capacity'];
        $available = $isUnlimited ? 0 : $capacity;
        $priceMinor = $validated['payment_type'] === 'free'
            ? 0
            : Currency::toMinorUnits((float) ($validated['price'] ?? 0), $validated['currency']);

        // Création de l'événement
        $event = new Event([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'daily_start_time' => $validated['daily_start_time'] ?? null,
            'daily_end_time' => $validated['daily_end_time'] ?? null,
            'location' => $validated['location'],
            'google_maps_url' => $validated['google_maps_url'] ?? null,
            'is_capacity_unlimited' => $isUnlimited,
            'capacity' => $capacity,
            'available_seats' => $available,
            'price' => $priceMinor,
            'currency' => strtoupper($validated['currency']),
            'allow_payment_numeric' => $request->boolean('allow_payment_numeric'),
            'allow_payment_physical' => $request->boolean('allow_payment_physical'),
            'allow_ticket_transfer' => $request->boolean('allow_ticket_transfer'),
            'cover_image' => $validated['cover_image'] ?? null,
            'organizer_id' => Auth::id(),
            'is_restricted_18' => $request->boolean('is_restricted_18'),
            'slug' => $slug,
            // Lien promo: Premium/Pro OU Admin OU environnement local/development OU bypass par ID
            'shareable_link' => (
                ($currentUser && ($currentUser->isAdmin() || in_array(($currentUser->subscription_plan ?? 'basic'), ['premium','pro'], true)))
                || app()->environment(['local','development'])
                || $hasBypass
            ) ? $shareLink : null,
            'is_interactive' => $request->boolean('is_interactive'),
            'interactive_public' => $request->boolean('interactive_public'),
            'interactive_starts_at' => $request->input('interactive_starts_at') ? Carbon::parse($request->input('interactive_starts_at')) : null,
            'interactive_ends_at' => $request->input('interactive_ends_at') ? Carbon::parse($request->input('interactive_ends_at')) : null,
        ]);

        $event->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Événement créé avec succès!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->loadCount('registrations');
        $isRegistered = false;
        $registration = null;

        if (auth()->check()) {
            $registration = $event->registrations()
                ->where('user_id', auth()->id())
                ->first();
            
            $isRegistered = !is_null($registration);
        }

        // Reviews: average rating and latest approved reviews
        $avgRating = (float) ($event->reviews()->avg('rating') ?? 0);
        $reviews = $event->reviews()->with('user')->take(10)->get();

        // Recommendations: based on user preferred categories, fallback to event category
        $preferredCategories = [];
        if (auth()->check()) {
            $preferredCategories = Event::query()
                ->whereHas('registrations', function ($q) { $q->where('user_id', auth()->id()); })
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category')
                ->toArray();
        }
        if (empty($preferredCategories) && $event->category) {
            $preferredCategories = [$event->category];
        }
        $recommendedEvents = Event::query()
            ->where('id', '!=', $event->id)
            ->when(!empty($preferredCategories), fn($q) => $q->whereIn('category', $preferredCategories))
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(6)
            ->get();

        // Can the current user review?
        $canReview = false;
        if (auth()->check() && $event->end_date && now()->gte($event->end_date)) {
            $hasRegistration = $isRegistered || Registration::where('event_id', $event->id)->where('user_id', auth()->id())->exists();
            $alreadyReviewed = EventReview::where('event_id', $event->id)->where('user_id', auth()->id())->exists();
            $canReview = $hasRegistration && !$alreadyReviewed;
        }

        return view('events.show', [
            'event' => $event,
            'isRegistered' => $isRegistered,
            'registration' => $registration,
            'avgRating' => $avgRating,
            'reviews' => $reviews,
            'recommendedEvents' => $recommendedEvents,
            'canReview' => $canReview,
        ]);
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', [
            'event' => $event,
            'currencies' => Currency::all(),
            'categories' => [
                'concert' => 'Concert',
                'conference' => 'Conférence',
                'formation' => 'Formation',
                'atelier' => 'Atelier',
                'sport' => 'Sport',
                'festival' => 'Festival',
                'meetup' => 'Meetup',
                'webinar' => 'Webinar',
                'autre' => 'Autre',
            ],
        ]);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $registrationsCount = $event->registrations()->count();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            // Autoriser l'édition d'événements passés: pas de contrainte after:now ici
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'google_maps_url' => 'nullable|url|max:255',
            'daily_start_time' => 'nullable|date_format:H:i',
            'daily_end_time' => 'nullable|date_format:H:i',
            'is_capacity_unlimited' => 'nullable|boolean',
            'capacity' => ['nullable','integer','min:1','required_unless:is_capacity_unlimited,1'],
            // Rendre facultatif; s'il n'est pas transmis, conserver la valeur actuelle
            'available_seats' => ['nullable', 'integer', 'min:' . $registrationsCount, 'lte:capacity'],
            'payment_type' => ['required', Rule::in(['free','paid'])],
            'price' => 'nullable|numeric|min:0',
            'currency' => ['required', 'string', 'size:3', Rule::in(array_keys(Currency::all()))],
            'allow_payment_numeric' => 'nullable|boolean',
            'allow_payment_physical' => 'nullable|boolean',
            'allow_ticket_transfer' => 'nullable|boolean',
            'is_restricted_18' => 'nullable|boolean',
            'is_interactive' => 'nullable|boolean',
            'interactive_public' => 'nullable|boolean',
            'interactive_starts_at' => 'nullable|date',
            'interactive_ends_at' => 'nullable|date|after_or_equal:interactive_starts_at',
        ]);

        // En mise à jour, empêcher de dépasser la capacité max du plan
        $currentUser = Auth::user();
        if ($currentUser && $currentUser->isOrganizer()) {
            $plan = $currentUser->subscription_plan ?: 'basic';
            $planCaps = [
                'basic' => ['max_capacity' => 50],
                'premium' => ['max_capacity' => 150],
                'pro' => ['max_capacity' => null],
            ];
            $caps = $planCaps[$plan] ?? $planCaps['basic'];
            if (!is_null($caps['max_capacity']) && (int) $validated['capacity'] > (int) $caps['max_capacity']) {
                return back()
                    ->withErrors(['capacity' => "Capacité maximale autorisée pour l'offre " . ucfirst($plan) . " : " . $caps['max_capacity'] . " places par événement."])
                    ->withInput();
            }
        }

        $isUnlimited = $request->boolean('is_capacity_unlimited');
        $capacity = $isUnlimited ? (int) ($validated['capacity'] ?? 0) : (int) $validated['capacity'];
        $available = $validated['available_seats'] ?? ($isUnlimited ? 0 : ($event->available_seats));
        $priceMinor = $validated['payment_type'] === 'free'
            ? 0
            : Currency::toMinorUnits((float) ($validated['price'] ?? 0), $validated['currency']);

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?? $event->category,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'daily_start_time' => $validated['daily_start_time'] ?? $event->daily_start_time,
            'daily_end_time' => $validated['daily_end_time'] ?? $event->daily_end_time,
            'location' => $validated['location'],
            'google_maps_url' => $validated['google_maps_url'] ?? $event->google_maps_url,
            'is_capacity_unlimited' => $isUnlimited,
            'capacity' => $capacity,
            'available_seats' => $available,
            'price' => $priceMinor,
            'currency' => strtoupper($validated['currency']),
            'allow_payment_numeric' => $request->boolean('allow_payment_numeric'),
            'allow_payment_physical' => $request->boolean('allow_payment_physical'),
            'allow_ticket_transfer' => $request->boolean('allow_ticket_transfer'),
            'is_restricted_18' => $request->boolean('is_restricted_18'),
            'is_interactive' => $request->boolean('is_interactive'),
            'interactive_public' => $request->boolean('interactive_public'),
            'interactive_starts_at' => $request->input('interactive_starts_at') ? Carbon::parse($request->input('interactive_starts_at')) : $event->interactive_starts_at,
            'interactive_ends_at' => $request->input('interactive_ends_at') ? Carbon::parse($request->input('interactive_ends_at')) : $event->interactive_ends_at,
        ]);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Événement mis à jour avec succès!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        // Supprimer les QR codes associés
        $event->registrations->each(function($registration) {
            if ($registration->qr_code_path) {
                $this->qrCodeService->delete($registration->qr_code_path);
            }
        });

        $event->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Événement supprimé avec succès!');
    }

    /**
     * Register the authenticated user to an event.
     */
    public function register(Request $request, Event $event)
    {
        $this->authorize('register', $event);

        // Bloquer les inscriptions si l'événement est terminé
        if ($event->end_date && now()->gte($event->end_date)) {
            return back()->with('error', "L'événement est terminé. Les inscriptions ne sont plus possibles.");
        }

        $userId = auth()->id();
        $user = auth()->user();

        // Si l'événement est restreint 18+, demander une confirmation simple côté serveur
        $ageConfirmed = false;
        if ($event->is_restricted_18) {
            $request->validate([
                'confirm_age' => ['accepted'],
            ], [
                'confirm_age.accepted' => 'Vous devez confirmer avoir au moins 18 ans pour continuer.',
            ]);
            $ageConfirmed = (bool) $request->boolean('confirm_age');
        }

        // Quantité demandée
        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) { $quantity = 1; }

        if (!$event->is_capacity_unlimited) {
            if ((int) $event->available_seats <= 0) {
                return back()->with('error', 'Désolé, il n\'y a plus de places disponibles pour cet événement.');
            }
            if ((int) $event->available_seats < $quantity) {
                return back()->with('error', 'Il ne reste que ' . (int) $event->available_seats . ' place(s) disponible(s).');
            }
        }

        // Autoriser plusieurs achats par utilisateur pour le même événement

        $registration = null;
        $isFreeEvent = (int) $event->price <= 0;

        // Choix du mode de paiement pour les événements payants (respecter les méthodes activées)
        $paymentMethod = null;
        if (! $isFreeEvent) {
            $allowedMethods = [];
            if ($event->allow_payment_numeric) { $allowedMethods[] = 'kkiapay'; }
            if ($event->allow_payment_physical) { $allowedMethods[] = 'physical'; }
            if (empty($allowedMethods)) {
                return back()->with('error', "Aucune méthode de paiement n'est activée sur cet événement.")->withInput();
            }
            $validatedPayment = $request->validate([
                'payment_method' => ['required', Rule::in($allowedMethods)],
            ], [
                'payment_method.required' => 'Veuillez choisir un mode de paiement.',
                'payment_method.in' => 'Mode de paiement invalide.',
            ]);
            $paymentMethod = $validatedPayment['payment_method'];
        }

        $sourceRef = $request->filled('ref') ? (string) $request->input('ref') : null;

        try {
            $registration = DB::transaction(function () use ($event, $userId, $isFreeEvent, $ageConfirmed, $paymentMethod, $sourceRef, $quantity) {
                $registration = new Registration([
                    'user_id' => $userId,
                    'quantity' => $quantity,
                    'qr_code_data' => (string) Str::uuid(),
                    'is_validated' => false,
                    'payment_status' => $isFreeEvent ? 'paid' : ($paymentMethod === 'physical' ? 'unpaid' : 'pending'),
                    'paid_at' => $isFreeEvent ? now() : null,
                    'payment_metadata' => $isFreeEvent ? ['mode' => 'free'] : ['mode' => ($paymentMethod ?? 'kkiapay')],
                    'age_restriction_passed' => $ageConfirmed,
                ]);

                $event->registrations()->save($registration);
                if (!$event->is_capacity_unlimited) {
                    $event->decrement('available_seats', $quantity);
                }

                if ($sourceRef) {
                    $event->increment('promo_registrations');
                }

                if ($isFreeEvent || ($paymentMethod === 'physical')) {
                    $qrCodeData = route('registrations.show', $registration->qr_code_data);
                    $qrCodePaths = $this->qrCodeService->generate($qrCodeData);

                    $registration->update([
                        'qr_code_path' => $qrCodePaths['svg'],
                        'qr_code_png_path' => $qrCodePaths['png'],
                    ]);
                }

                // Créer les tickets (un par place)
                for ($i = 0; $i < $quantity; $i++) {
                    Ticket::create([
                        'event_id' => $event->id,
                        'registration_id' => $registration->id,
                        'owner_user_id' => $userId,
                        'qr_code_data' => (string) Str::uuid(),
                        'status' => 'valid',
                        'paid' => $isFreeEvent ? true : ($paymentMethod === 'physical' ? false : false),
                        'payment_method' => $isFreeEvent ? 'free' : ($paymentMethod === 'physical' ? 'physical' : null),
                    ]);
                }

                // Compter les billets gratuits comme "vendus" immédiatement (x quantity)
                if ($isFreeEvent) {
                    $event->increment('total_tickets_sold', $quantity);
                }

                return $registration;
            });
        } catch (\Throwable $exception) {
            report($exception);
            return back()->with('error', 'Une erreur s\'est produite lors de votre inscription. Veuillez réessayer.');
        }

        // Notifications: participant + organisateur
        try {
            $event->loadMissing('organizer');
            $registration->loadMissing(['event', 'user']);
            // Participant: confirmation/paiement à finaliser
            $registration->user->notify(new \App\Notifications\ParticipantRegistrationCreated($registration));
            // Organisateur: nouvelle inscription
            if ($event->organizer) {
                $event->organizer->notify(new \App\Notifications\OrganizerNewRegistration($registration));
            }
        } catch (\Throwable $e) {
            report($e);
        }

        if ($isFreeEvent || ($paymentMethod === 'physical')) {
            return redirect()
                ->route('registrations.show', $registration->qr_code_data)
                ->with('success', $isFreeEvent ? 'Inscription réussie! Voici votre billet.' : 'Inscription enregistrée (paiement sur place). Voici votre billet.');
        }

        // Kkiapay: rediriger vers la page de paiement où le widget sera affiché
        return redirect()
            ->route('payments.pending', $registration)
            ->with('info', 'Veuillez finaliser votre paiement pour confirmer l\'inscription.');
    }

    /**
     * Cancel the authenticated user's registration to an event.
     */
    public function cancelRegistration(Event $event)
    {
        $registration = $event->registrations()
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->authorize('delete', $registration);

        return DB::transaction(function () use ($event, $registration) {
            // Supprimer le QR code
            if ($registration->qr_code_path) {
                $this->qrCodeService->delete($registration->qr_code_path);
            }

            // Supprimer l'inscription
            $registration->delete();

            // Restaurer le nombre de places disponibles (événements à capacité limitée uniquement)
            if (!$event->is_capacity_unlimited) {
                $qty = max(1, (int) ($registration->quantity ?? 1));
                $newAvailable = (int) $event->available_seats + $qty;
                if ($event->capacity !== null) {
                    $newAvailable = min((int) $event->capacity, $newAvailable);
                }
                $event->update(['available_seats' => $newAvailable]);
            }

            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Inscription annulée avec succès.');
        });
    }
}
