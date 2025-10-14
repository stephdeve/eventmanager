<?php

namespace App\Http\Controllers;

use App\Events\TicketValidated;
use App\Models\Event;
use App\Models\Registration;
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
        $registration->load(['event', 'user']);

        $isOwner = auth()->check() && auth()->id() === $registration->user_id;

        if ($isOwner && $registration->payment_status === 'pending') {
            return redirect()
                ->route('payments.pending', $registration)
                ->with('warning', 'Le paiement de ce billet est requis avant d\'y accéder.');
        }

        // Générer l'URL du QR code si elle n'existe pas
        if (!$registration->qr_code_path) {
            $qrCodeData = route('registrations.show', $registration->qr_code_data);
            $qrCodePaths = $this->qrCodeService->generate($qrCodeData);
            $registration->update([
                'qr_code_path' => $qrCodePaths['svg'],
                'qr_code_png_path' => $qrCodePaths['png'],
            ]);
            $registration->refresh();
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
            ], 200);
        }

        // Marquer le billet comme validé
        $registration->update([
            'is_validated' => true,
            'validated_at' => now(),
            'validated_by' => auth()->id()
        ]);

        // Recharger les relations
        $registration->load(['event', 'user']);

        // Diffuser la validation en temps réel
        event(new TicketValidated($registration));

        return response()->json([
            'success' => true,
            'message' => 'Billet validé avec succès!',
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
        ]);
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
