<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\KkiapayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class PaymentController extends Controller
{
    protected KkiapayService $kkiapayService;

    public function __construct(KkiapayService $kkiapayService)
    {
        $this->kkiapayService = $kkiapayService;
        $this->middleware('auth')->except('callback');
    }

    public function pending(Request $request, Registration $registration)
    {
        $this->authorize('view', $registration);

        if ($registration->payment_status === 'paid') {
            return redirect()
                ->route('registrations.show', $registration->qr_code_data)
                ->with('success', 'Le paiement est déjà confirmé.');
        }

        // Kkiapay: aucune session préalable n'est nécessaire, le widget est affiché côté client

        $registration->load('event');

        return view('payments.pending', [
            'registration' => $registration,
            'event' => $registration->event,
        ]);
    }

    public function callback(Request $request)
    {
        // Optionnel: implémentation webhook Kkiapay si nécessaire
        return response()->json(['status' => 'ignored']);
    }

    public function confirm(Request $request, Registration $registration)
    {
        $this->authorize('view', $registration);

        $transactionId = $request->query('transaction_id') ?? $request->input('transaction_id');
        if (!$transactionId) {
            return redirect()
                ->route('payments.pending', $registration)
                ->with('error', 'Transaction introuvable. Veuillez réessayer.');
        }

        try {
            $ok = $this->kkiapayService->confirmPayment($registration, (string) $transactionId);

            if ($ok) {
                return redirect()
                    ->route('registrations.show', $registration->qr_code_data)
                    ->with('success', 'Paiement confirmé. Voici votre billet.');
            }

            return redirect()
                ->route('payments.pending', $registration)
                ->with('error', 'Paiement non confirmé. Veuillez réessayer.');
        } catch (\Throwable $e) {
            // Journaliser des détails utiles côté serveur
            if ($e instanceof RequestException) {
                Log::warning('Kkiapay confirm exception', [
                    'status' => optional($e->response)->status(),
                    'body' => optional($e->response)->body(),
                    'transaction_id' => $transactionId,
                ]);
            }
            report($e);

            $message = 'Une erreur est survenue lors de la confirmation du paiement.';
            if (app()->isLocal() || config('app.debug')) {
                $message .= ' ' . $e->getMessage();
                if ($e instanceof RequestException && $e->response) {
                    $message .= ' [HTTP ' . $e->response->status() . ']';
                }
            }

            return redirect()
                ->route('payments.pending', $registration)
                ->with('error', $message);
        }
    }
}
