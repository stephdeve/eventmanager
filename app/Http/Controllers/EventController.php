<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Services\QrCodeService;
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
        return view('events.create');
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
        ], [
            'start_date.after' => 'La date de début doit être une date future.',
            'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
        ]);

        // Traitement de l'image de couverture si elle est fournie
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('events/cover_images', 'public');
            $validated['cover_image'] = $path;
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
            'price' => $validated['price'] * 100, // Stocker en centimes
            'cover_image' => $validated['cover_image'] ?? null,
            'organizer_id' => Auth::id(),
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
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => [
                'required',
                'date',
                'after:now',
                Rule::when(
                    $event->registrations()->exists(),
                    fn() => Rule::in([$event->event_date->toDateTimeString()]),
                    'La date ne peut pas être modifiée car des inscriptions existent déjà.'
                )
            ],
            'location' => 'required|string|max:255',
            'available_seats' => [
                'required',
                'integer',
                'min:1',
                'min:' . $event->registrations_count
            ],
        ]);

        $event->update($validated);

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
    public function register(Event $event)
    {
        $this->authorize('register', $event);

        return DB::transaction(function () use ($event) {
            // Vérifier s'il reste des places disponibles
            if (!$event->hasAvailableSeats()) {
                return back()->with('error', 'Désolé, il n\'y a plus de places disponibles pour cet événement.');
            }

            // Vérifier si l'utilisateur est déjà inscrit
            if ($event->attendees()->where('user_id', auth()->id())->exists()) {
                return back()->with('error', 'Vous êtes déjà inscrit à cet événement.');
            }

            // Créer l'inscription
            $registration = new Registration([
                'user_id' => auth()->id(),
                'qr_code_data' => (string) Str::uuid(),
                'is_validated' => false,
            ]);

            $event->registrations()->save($registration);

            // Générer le QR code
            $qrCodeData = route('registrations.show', $registration->qr_code_data);
            $qrCodePaths = $this->qrCodeService->generate($qrCodeData);

            // Mettre à jour les chemins du QR code
            $registration->update([
                'qr_code_path' => $qrCodePaths['svg'],
                'qr_code_png_path' => $qrCodePaths['png'],
            ]);

            // Décrémenter le nombre de places disponibles
            $event->decrement('available_seats');

            return redirect()
                ->route('registrations.show', $registration->qr_code_data)
                ->with('success', 'Inscription réussie! Voici votre billet.');
        });
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
