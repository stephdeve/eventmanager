<?php

namespace App\Http\Controllers;

use App\Services\KkiapayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{
    protected KkiapayService $kkiapay;

    public function __construct(KkiapayService $kkiapay)
    {
        $this->middleware('auth');
        $this->kkiapay = $kkiapay;
    }

    public function plans()
    {
        $user = Auth::user();
        // Laisser accéder à la page des offres si l'abonnement est inexistant/expiré
        if ($user->isOrganizer() && method_exists($user, 'hasActiveSubscription') && $user->hasActiveSubscription()) {
            return redirect()->route('dashboard');
        }

        $plans = [
            'basic' => [
                'name' => 'Basique',
                'price' => 30000,
                'limits' => [
                    '50 places max par événement',
                    '10 événements par mois',
                ],
            ],
            'premium' => [
                'name' => 'Premium',
                'price' => 60000,
                'limits' => [
                    '150 places max par événement',
                    '30 événements par mois',
                ],
            ],
            'pro' => [
                'name' => 'Pro',
                'price' => 90000,
                'limits' => [
                    'Places illimitées par événement',
                    '100 événements par mois',
                ],
            ],
        ];

        return view('subscriptions.plans', compact('plans', 'user'));
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        $plan = $request->query('plan') ?? $request->input('plan');
        $transactionId = $request->query('transaction_id') ?? $request->input('transaction_id');

        if (!in_array($plan, ['basic', 'premium', 'pro'], true)) {
            return redirect()->route('subscriptions.plans')->with('error', 'Formule invalide.');
        }
        if (!$transactionId) {
            return redirect()->route('subscriptions.plans')->with('error', 'Transaction introuvable.');
        }

        try {
            $data = $this->kkiapay->verify((string) $transactionId);
            $status = strtoupper((string) ($data['status'] ?? $data['state'] ?? ''));
            $ok = in_array($status, ['SUCCESS', 'SUCCESSFUL', 'COMPLETED'], true);

            if (!$ok) {
                return redirect()->route('subscriptions.plans')->with('error', 'Paiement non confirmé.');
            }

            $now = now();
            $newExpiry = ($user->subscription_status === 'active' && $user->subscription_expires_at && $user->subscription_expires_at->isFuture())
                ? $user->subscription_expires_at->clone()->addMonth()
                : $now->clone()->addMonth();

            $user->forceFill([
                'role' => 'organizer',
                'subscription_plan' => $plan,
                'subscription_status' => 'active',
                'subscription_started_at' => $user->subscription_started_at ?: $now,
                'subscription_expires_at' => $newExpiry,
            ])->save();

            // Notification de confirmation d'abonnement
            try {
                $user->notify(new \App\Notifications\OrganizerSubscriptionConfirmed($plan, $newExpiry));
            } catch (\Throwable $e) {
                report($e);
            }

            return redirect()->route('dashboard')->with('success', 'Abonnement activé. Bienvenue en tant qu’organisateur !');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('subscriptions.plans')->with('error', 'Erreur lors de la confirmation du paiement.');
        }
    }
}
