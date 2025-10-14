<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\KkiapayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            report($e);

            return redirect()
                ->route('payments.pending', $registration)
                ->with('error', 'Une erreur est survenue lors de la confirmation du paiement.');
        }
    }
}
