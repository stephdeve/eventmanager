<?php

namespace App\Http\Controllers;

use App\Events\TicketValidated;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use App\Services\QrCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->middleware('auth');
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Validate a ticket using its QR code data (code string).
     */
    public function validateTicketByCode(string $code)
    {
        // 1) Try to validate a Ticket code first (new ticket-level QR)
        $ticket = Ticket::where('qr_code_data', $code)->first();
        if ($ticket) {
            // Permission: organizer/admin can scan; owner cannot validate
            $this->authorize('scan', Registration::class);

            // Load relations
            $ticket->load(['event', 'owner']);

            // Reject if already used
            if ($ticket->status === 'used') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce billet a déjà été utilisé.',
                ], 409);
            }

            // Payment rules: if numeric and not paid, reject; if physical unpaid, allow with notice
            if (($ticket->payment_method === 'numeric' || $ticket->payment_method === null) && !$ticket->paid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket invalide ou paiement en attente. Finalisez le paiement en ligne.',
                ], 422);
            }

            // Atomic update to mark used
            $updated = DB::transaction(function () use ($ticket) {
                return Ticket::whereKey($ticket->id)
                    ->where('status', '!=', 'used')
                    ->update([
                        'status' => 'used',
                        'validated_at' => now(),
                        'validated_by' => auth()->id(),
                        'scanned_at' => now(),
                    ]);
            });

            if ($updated !== 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce billet a déjà été utilisé.',
                ], 409);
            }

            $ticket->refresh()->load(['event', 'owner']);

            $notice = null;
            if (!$ticket->paid && $ticket->payment_method === 'physical') {
                $notice = 'Accès autorisé — Paiement à effectuer sur place.';
            }

            return response()->json([
                'success' => true,
                'message' => 'Billet validé avec succès!',
                'ticket' => [
                    'id' => $ticket->id,
                    'event' => [
                        'title' => $ticket->event->title,
                    ],
                    'owner' => [
                        'name' => optional($ticket->owner)->name,
                    ],
                    'status' => $ticket->status,
                    'validated_at' => optional($ticket->validated_at)->format('d/m/Y H:i'),
                    'paid' => (bool) $ticket->paid,
                    'payment_method' => $ticket->payment_method,
                    'notice' => $notice,
                ]
            ]);
        }

        // 2) Backward compatibility: registration-level QR
        $registration = Registration::where('qr_code_data', $code)->first();

        if (!$registration) {
            return response()->json([
                'success' => false,
                'message' => 'Billet introuvable.',
            ], 404);
        }

        $this->authorize('validate', $registration);

        if ($registration->is_validated) {
            $registration->load(['event', 'user']);
            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été validé.',
                'registration' => [
                    'event' => [
                        'title' => $registration->event->title,
                    ],
                    'user' => [
                        'name' => $registration->user->name,
                    ],
                    'is_validated' => true,
                    'validated_at' => optional($registration->validated_at)->format('d/m/Y H:i'),
                ]
            ], 409);
        }

        if (in_array($registration->payment_status, ['pending', 'failed'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket invalide ou paiement en attente. Finalisez le paiement en ligne.',
            ], 422);
        }

        $updated = DB::transaction(function () use ($registration) {
            return Registration::whereKey($registration->id)
                ->where('is_validated', false)
                ->update([
                    'is_validated' => true,
                    'validated_at' => now(),
                    'validated_by' => auth()->id(),
                ]);
        });

        if ($updated !== 1) {
            $registration->refresh()->load(['event', 'user']);
            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été validé.',
                'registration' => [
                    'event' => [
                        'title' => $registration->event->title,
                    ],
                    'user' => [
                        'name' => $registration->user->name,
                    ],
                    'is_validated' => true,
                    'validated_at' => optional($registration->validated_at)->format('d/m/Y H:i'),
                ]
            ], 409);
        }

        $registration->refresh()->load(['event', 'user']);

        event(new TicketValidated($registration));

        try {
            $registration->user->notify(new \App\Notifications\ParticipantCheckInConfirmed($registration));
        } catch (\Throwable $e) {
            report($e);
        }

        $notice = null;
        if ($registration->payment_status === 'unpaid') {
            $notice = 'Accès autorisé — Paiement à effectuer sur place.';
        }

        return response()->json([
            'success' => true,
            'message' => 'Billet validé avec succès!',
            'registration' => [
                'id' => $registration->id,
                'event' => [
                    'title' => $registration->event->title,
                ],
                'user' => [
                    'name' => $registration->user->name,
                ],
                'is_validated' => true,
                'validated_at' => optional($registration->validated_at)->format('d/m/Y H:i'),
                'payment_status' => $registration->payment_status,
                'notice' => $notice,
            ]
        ]);
    }

    /**
     * Display a listing of the user's registrations.
     */
    public function index()
    {
        $this->authorize('viewAny', Registration::class);
        
        $registrations = Auth::user()->registrations()
            ->with(['event' => function($query) {
                $query->withCount('registrations');
            }])
            ->latest()
            ->paginate(10);

        return view('registrations.index', compact('registrations'));
    }

    /**
     * Display the specified registration/ticket.
     */
    public function show($code)
    {
        $registration = Registration::where('qr_code_data', $code)->firstOrFail();

        $this->authorize('view', $registration);

        // Charger les relations nécessaires
        $registration->load(['event', 'user', 'tickets']);

        $isOwner = auth()->check() && auth()->id() === $registration->user_id;

        if ($isOwner && $registration->payment_status === 'pending') {
            return redirect()
                ->route('payments.pending', $registration)
                ->with('warning', 'Le paiement de ce billet est requis avant d\'y accéder.');
        }

        // Assurer les QR codes par ticket si disponibles
        foreach ($registration->tickets as $ticket) {
            if (!$ticket->qr_code_path) {
                $qrCodeData = route('tickets.show', $ticket->qr_code_data);
                $paths = $this->qrCodeService->generate($qrCodeData);
                $ticket->forceFill([
                    'qr_code_path' => $paths['svg'] ?? null,
                    'qr_code_png_path' => $paths['png'] ?? null,
                ])->save();
            }
        }

        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the QR code scanner for organizers.
     */
    public function scanner()
    {
        $this->authorize('scan', Registration::class);
        
        return view('registrations.scanner');
    }

    /**
     * Validate a ticket by scanning its QR code.
     */
    /**
     * Validate a ticket by scanning its QR code.
     */
    public function validateTicket(Registration $registration)
    {
        $this->authorize('validate', $registration);

        // Vérifier si le billet est déjà validé
        if ($registration->is_validated) {
            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été validé.',
                'registration' => [
                    'event' => [
                        'title' => $registration->event->title,
                    ],
                    'user' => [
                        'name' => $registration->user->name,
                    ],
                    'is_validated' => true,
                    'validated_at' => optional($registration->validated_at)->format('d/m/Y H:i'),
                ]
            ], 409);
        }

        // Règles de paiement: refuser si paiement en attente (numérique), autoriser si unpaid (physique)
        if (in_array($registration->payment_status, ['pending', 'failed'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket invalide ou paiement en attente. Finalisez le paiement en ligne.',
            ], 422);
        }

        // Marquer le billet comme validé (atomiquement)
        $updated = DB::transaction(function () use ($registration) {
            return Registration::whereKey($registration->id)
                ->where('is_validated', false)
                ->update([
                    'is_validated' => true,
                    'validated_at' => now(),
                    'validated_by' => auth()->id(),
                ]);
        });

        if ($updated !== 1) {
            // Conflit concurrent: déjà validé entre-temps
            $registration->refresh();
            $registration->load(['event', 'user']);
            return response()->json([
                'success' => false,
                'message' => 'Ce billet a déjà été validé.',
                'registration' => [
                    'event' => [
                        'title' => $registration->event->title,
                    ],
                    'user' => [
                        'name' => $registration->user->name,
                    ],
                    'is_validated' => true,
                    'validated_at' => optional($registration->validated_at)->format('d/m/Y H:i'),
                ]
            ], 409);
        }

        // Recharger les relations
        $registration->refresh()->load(['event', 'user']);

        // Diffuser la validation en temps réel
        event(new TicketValidated($registration));

        // Notifier le participant (check-in confirmé)
        try {
            $registration->user->notify(new \App\Notifications\ParticipantCheckInConfirmed($registration));
        } catch (\Throwable $e) {
            report($e);
        }

        $notice = null;
        if ($registration->payment_status === 'unpaid') {
            $notice = 'Accès autorisé — Paiement à effectuer sur place.';
        }

        return response()->json([
            'success' => true,
            'message' => 'Billet validé avec succès!',
            'registration' => [
                'id' => $registration->id,
                'event' => [
                    'title' => $registration->event->title,
                ],
                'user' => [
                    'name' => $registration->user->name,
                ],
                'is_validated' => true,
                'validated_at' => optional($registration->validated_at)->format('d/m/Y H:i'),
                'payment_status' => $registration->payment_status,
                'notice' => $notice,
            ]
        ]);
    }

    /**
     * Marquer un billet comme payé (paiement physique encaissé).
     */
    public function markPaid(Request $request, Registration $registration)
    {
        $this->authorize('validate', $registration); // organiser ou admin

        if ($registration->payment_status === 'paid') {
            return back()->with('info', 'Ce billet est déjà marqué comme payé.');
        }

        DB::transaction(function () use ($registration) {
            $event = $registration->event()->lockForUpdate()->first();

            $registration->forceFill([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'payment_metadata' => array_merge((array) $registration->payment_metadata, [
                    'mode' => 'physical',
                    'manual_paid_by' => auth()->id(),
                ]),
            ])->save();

            // Marquer tous les tickets liés comme payés (paiement sur place)
            Ticket::where('registration_id', $registration->id)
                ->update([
                    'paid' => true,
                    'payment_method' => 'physical',
                ]);

            // Enregistrer un paiement "cash" pour la traçabilité + totaux
            $ref = 'CASH-REG-' . $registration->id;
            $existing = \App\Models\EventPayment::where('provider', 'cash')
                ->where('provider_reference', $ref)
                ->first();
            if (!$existing) {
                \App\Models\EventPayment::create([
                    'user_id' => $registration->user_id,
                    'event_id' => $event->id,
                    'registration_id' => $registration->id,
                    'provider' => 'cash',
                    'provider_reference' => $ref,
                    'method' => 'cash',
                    'status' => 'success',
                    'amount_minor' => (int) $event->price,
                    'currency' => $event->currency ?? 'XOF',
                    'paid_at' => now(),
                    'metadata' => ['mode' => 'physical', 'recorded_by' => auth()->id()],
                ]);

                // Mettre à jour les totaux (revenus + tickets vendus)
                $event->increment('total_revenue_minor', (int) $event->price);
                $event->increment('total_tickets_sold', 1);
            }
        });

        return back()->with('success', 'Billet marqué comme payé.');
    }

    /**
     * Download the ticket as a PDF.
     */
    public function download($code)
    {
        $registration = Registration::where('qr_code_data', $code)->firstOrFail();

        $this->authorize('viewQrCode', $registration);

        $registration->load(['event', 'user']);

        $isOwner = auth()->check() && auth()->id() === $registration->user_id;

        if ($isOwner && $registration->payment_status === 'pending') {
            return redirect()
                ->route('payments.pending', $registration)
                ->with('warning', 'Le paiement doit être finalisé avant de télécharger le billet.');
        }

        // Générer les QR codes s'ils n'existent pas
        if (!$registration->qr_code_path || !$registration->qr_code_png_path) {
            $qrCodeData = route('registrations.show', $registration->qr_code_data);
            $qrCodePaths = $this->qrCodeService->generate($qrCodeData);
            $registration->update([
                'qr_code_path' => $qrCodePaths['svg'],
                'qr_code_png_path' => $qrCodePaths['png'],
            ]);
            $registration->refresh();
        }

        $qrCodeDataUrl = null;

        if (Storage::disk('public')->exists($registration->qr_code_path)) {
            $qrCodeContent = Storage::disk('public')->get($registration->qr_code_path);
            $qrCodeDataUrl = 'data:image/svg+xml;base64,' . base64_encode($qrCodeContent);
        }

        $pdf = Pdf::loadView('pdf.ticket', [
            'registration' => $registration,
            'qrCodeDataUrl' => $qrCodeDataUrl,
        ]);

        $filename = 'billet-' . $registration->event->slug . '-' . $registration->user->id . '.pdf';

        $pdfContents = $pdf->output();

        if (!class_exists('\ZipArchive')) {
            return response($pdfContents, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        $pdfPath = Storage::disk('local')->put('temp/' . $filename, $pdfContents);

        $zipFilename = 'billet-' . $registration->event->slug . '-' . $registration->user->id . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFilename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $zip->addFile(storage_path('app/' . $pdfPath), $filename);

            if ($registration->qr_code_png_path && Storage::disk('public')->exists($registration->qr_code_png_path)) {
                $zip->addFile(storage_path('app/public/' . $registration->qr_code_png_path), 'qr-code-' . $registration->qr_code_data . '.png');
            }

            $zip->close();
        }

        // Supprimer le PDF temporaire
        Storage::disk('local')->delete($pdfPath);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Show the list of attendees for an event (organizer only).
     */
    public function attendees(Event $event)
    {
        $this->authorize('viewAttendees', $event);
        
        $attendees = $event->registrations()
            ->with('user')
            ->orderBy('is_validated')
            ->orderBy('created_at')
            ->paginate(20);

        $statistics = [
            'total' => $event->registrations()->count(),
            'validated' => $event->registrations()->where('is_validated', true)->count(),
            'remaining' => max(0, (int) $event->available_seats),
        ];

        return view('registrations.attendees', [
            'event' => $event,
            'attendees' => $attendees,
            'statistics' => $statistics,
        ]);
    }
}
