<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Services\QrCodeService;
use App\Support\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        ]);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        // Validation des données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
            'location' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'currency' => ['required', 'string', 'size:3', Rule::in(array_keys(Currency::all()))],
            'is_restricted_18' => 'nullable|boolean',
        ], [
            'start_date.after' => 'La date de début doit être une date future.',
            'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
        ]);

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

        // Création de l'événement
        $event = new Event([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'available_seats' => $validated['capacity'], // Au départ, tous les sièges sont disponibles
            'price' => Currency::toMinorUnits($validated['price'], $validated['currency']),
            'currency' => strtoupper($validated['currency']),
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

        return view('events.show', [
            'event' => $event,
            'isRegistered' => $isRegistered,
            'registration' => $registration,
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
            // Autoriser l'édition d'événements passés: pas de contrainte after:now ici
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            // Rendre facultatif; s'il n'est pas transmis, conserver la valeur actuelle
            'available_seats' => ['nullable', 'integer', 'min:' . $registrationsCount, 'lte:capacity'],
            'price' => 'required|numeric|min:0',
            'currency' => ['required', 'string', 'size:3', Rule::in(array_keys(Currency::all()))],
            'is_restricted_18' => 'nullable|boolean',
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

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'location' => $validated['location'],
            'capacity' => $validated['capacity'],
            'available_seats' => $validated['available_seats'] ?? $event->available_seats,
            'price' => Currency::toMinorUnits($validated['price'], $validated['currency']),
            'currency' => strtoupper($validated['currency']),
            'is_restricted_18' => $request->boolean('is_restricted_18'),
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

        if (!$event->hasAvailableSeats()) {
            return back()->with('error', 'Désolé, il n\'y a plus de places disponibles pour cet événement.');
        }

        if ($event->registrations()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'Vous êtes déjà inscrit à cet événement.');
        }

        $registration = null;
        $isFreeEvent = (int) $event->price <= 0;

        // Choix du mode de paiement pour les événements payants
        $paymentMethod = null;
        if (! $isFreeEvent) {
            $validatedPayment = $request->validate([
                'payment_method' => ['required', Rule::in(['kkiapay', 'physical'])],
            ], [
                'payment_method.required' => 'Veuillez choisir un mode de paiement.',
                'payment_method.in' => 'Mode de paiement invalide.',
            ]);
            $paymentMethod = $validatedPayment['payment_method'];
        }

        $sourceRef = $request->filled('ref') ? (string) $request->input('ref') : null;

        try {
            $registration = DB::transaction(function () use ($event, $userId, $isFreeEvent, $ageConfirmed, $paymentMethod, $sourceRef) {
                $registration = new Registration([
                    'user_id' => $userId,
                    'qr_code_data' => (string) Str::uuid(),
                    'is_validated' => false,
                    'payment_status' => $isFreeEvent ? 'paid' : ($paymentMethod === 'physical' ? 'unpaid' : 'pending'),
                    'paid_at' => $isFreeEvent ? now() : null,
                    'payment_metadata' => $isFreeEvent ? ['mode' => 'free'] : ['mode' => ($paymentMethod ?? 'kkiapay')],
                    'age_restriction_passed' => $ageConfirmed,
                ]);

                $event->registrations()->save($registration);
                $event->decrement('available_seats');

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

                // Compter les billets gratuits comme "vendus" immédiatement
                if ($isFreeEvent) {
                    $event->increment('total_tickets_sold');
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

            // Incrémenter le nombre de places disponibles
            $event->increment('available_seats');

            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Inscription annulée avec succès.');
        });
    }
}
