<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketTransfer;
use App\Models\User;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->middleware('auth');
        $this->qrCodeService = $qrCodeService;
    }

    public function show(string $code)
    {
        $ticket = Ticket::where('qr_code_data', $code)->firstOrFail();
        $ticket->load(['event', 'owner']);

        $user = Auth::user();
        $isOwner = $user && $ticket->owner_user_id === $user->id;
        $isOrganizer = $user && $ticket->event && $ticket->event->organizer_id === $user->id;
        $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();

        if (!($isOwner || $isOrganizer || $isAdmin)) {
            abort(403);
        }

        if (!$ticket->qr_code_path) {
            $qrCodeData = route('tickets.show', $ticket->qr_code_data);
            $paths = $this->qrCodeService->generate($qrCodeData);
            $ticket->forceFill([
                'qr_code_path' => $paths['svg'] ?? null,
                'qr_code_png_path' => $paths['png'] ?? null,
            ])->save();
        }

        return view('tickets.show', compact('ticket'));
    }

    public function transfer(Request $request, string $code)
    {
        $ticket = Ticket::where('qr_code_data', $code)->firstOrFail();
        $ticket->load(['event', 'owner']);

        $user = Auth::user();
        if (!$user || $ticket->owner_user_id !== $user->id) {
            abort(403);
        }

        // Check event allows transfers and not ended and ticket is valid
        if (!$ticket->event || !$ticket->event->allow_ticket_transfer) {
            return back()->with('error', 'Le transfert de ticket n\'est pas autorisé pour cet événement.');
        }
        if ($ticket->event->end_date && now()->gte($ticket->event->end_date)) {
            return back()->with('error', 'L\'événement est terminé. Le transfert n\'est plus possible.');
        }
        if ($ticket->status !== 'valid') {
            return back()->with('error', 'Ce ticket ne peut pas être transféré.');
        }

        $data = $request->validate([
            'recipient_email' => ['required', 'email'],
        ], [
            'recipient_email.required' => 'Veuillez saisir l\'email du destinataire.',
            'recipient_email.email' => 'Adresse email invalide.',
        ]);

        $recipientEmail = strtolower(trim($data['recipient_email']));
        $recipientUser = User::whereRaw('LOWER(email) = ?', [$recipientEmail])->first();

        try {
            DB::transaction(function () use ($ticket, $user, $recipientUser, $recipientEmail) {
                // Log transfer
                TicketTransfer::create([
                    'ticket_id' => $ticket->id,
                    'from_user_id' => $ticket->owner_user_id,
                    'to_user_id' => $recipientUser?->id,
                    'to_email' => $recipientUser?->email ? null : $recipientEmail,
                    'performed_by' => $user->id,
                    'transferred_at' => now(),
                    'metadata' => null,
                ]);

                // Reassign owner and note recipient
                $ticket->owner_user_id = $recipientUser?->id;
                $ticket->transferred_to = $recipientUser?->email ?: $recipientEmail;

                // Regenerate QR code
                $ticket->qr_code_data = (string) Str::uuid();
                $qrDataUrl = route('tickets.show', $ticket->qr_code_data);
                try {
                    $paths = $this->qrCodeService->generate($qrDataUrl);
                    $ticket->qr_code_path = $paths['svg'] ?? null;
                    $ticket->qr_code_png_path = $paths['png'] ?? null;
                } catch (\Throwable $e) {
                    Log::warning('QR generation failed on transfer', ['ticket_id' => $ticket->id, 'error' => $e->getMessage()]);
                    $ticket->qr_code_path = null;
                    $ticket->qr_code_png_path = null;
                }

                $ticket->save();

                // Notify recipient (best-effort)
                if ($recipientUser) {
                    try {
                        $recipientUser->notify(new \App\Notifications\TicketTransferredToYou($ticket));
                    } catch (\Throwable $e) {
                        Log::info('Notification to recipient failed', ['user_id' => $recipientUser->id, 'error' => $e->getMessage()]);
                    }
                } else {
                    // Send email with info and QR link if public storage
                    if ($ticket->qr_code_png_path) {
                        $pngUrl = asset('storage/' . ltrim($ticket->qr_code_png_path, '/'));
                        try {
                            Mail::raw("Vous avez reçu un billet transféré. Présentez ce QR à l'entrée: \n\n" . $pngUrl, function ($message) use ($recipientEmail) {
                                $message->to($recipientEmail)->subject('Vous avez reçu un ticket');
                            });
                        } catch (\Throwable $e) {
                            Log::info('Mail to recipient failed', ['email' => $recipientEmail, 'error' => $e->getMessage()]);
                        }
                    }
                }
            });
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Le transfert a échoué. Veuillez réessayer.');
        }

        // Old owner loses access; redirect them away
        return redirect()->route('dashboard')->with('success', 'Le ticket a été transféré. Vous n\'y avez plus accès.');
    }
}
