<?php

namespace App\Http\Controllers;

use App\Services\KkiapayService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CoinsController extends Controller
{
    protected KkiapayService $kkiapay;

    public function __construct(KkiapayService $kkiapay)
    {
        $this->kkiapay = $kkiapay;
        $this->middleware('auth')->only(['checkout','confirmKkiapay']);
    }

    /**
     * Lance un achat de coins via Kkiapay et renvoie les paramètres publics.
     */
    public function checkout(Request $request)
    {
        // Kkiapay ne nécessite pas de checkout serveur: le widget est lancé côté client.
        // On garde l'endpoint pour compatibilité, mais on renvoie les paramètres publics.
        $data = $request->validate([
            'coins' => ['required','integer','min:10','max:100000'],
        ]);
        $coins = (int) $data['coins'];
        $priceMinor = (int) (\App\Models\Setting::get('interactive.coin_price_minor', 100) ?? 100);
        $amount = max(1, $coins * $priceMinor); // XOF major == minor
        return response()->json([
            'success' => true,
            'provider' => 'kkiapay',
            'amount' => $amount,
            'currency' => strtoupper(config('app.currency', 'XOF')),
            'public_key' => config('services.kkiapay.public_key'),
            'sandbox' => (bool) config('services.kkiapay.sandbox', true),
        ]);
    }

    /**
     * Confirme un achat de coins via Kkiapay, vérifie la transaction, crédite le wallet.
     */
    public function confirmKkiapay(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => ['required','string','max:255'],
            'coins' => ['required','integer','min:1','max:100000'],
        ]);
        $coins = (int) $data['coins'];
        $tx = (string) $data['transaction_id'];
        try {
            // Vérifier la transaction auprès de Kkiapay
            $resp = $this->kkiapay->verify($tx);
            $status = strtoupper((string) (\Illuminate\Support\Arr::get($resp, 'status')
                ?? \Illuminate\Support\Arr::get($resp, 'state')
                ?? ''));
            $ok = in_array($status, ['SUCCESS','SUCCESSFUL','COMPLETED'], true);
            if (!$ok) {
                return response()->json(['success' => false, 'message' => 'Paiement non confirmé.'], 422);
            }

            // Valider le montant payé vs coins demandés
            $amountMajor = (int) (\Illuminate\Support\Arr::get($resp, 'amount')
                ?? \Illuminate\Support\Arr::get($resp, 'monetaryAmount')
                ?? 0);
            $expected = $coins * (int) (\App\Models\Setting::get('interactive.coin_price_minor', 100) ?? 100);
            if ($amountMajor !== $expected) {
                Log::warning('Coins amount mismatch', ['amount' => $amountMajor, 'expected' => $expected, 'coins' => $coins, 'tx' => $tx]);
                return response()->json(['success' => false, 'message' => 'Montant invalide.'], 422);
            }

            // Créditer le wallet
            $wallet = app(WalletService::class)->credit(Auth::id(), $coins, ['reason' => 'coins_purchase', 'tx' => $tx]);
            return response()->json(['success' => true, 'balance' => (int) $wallet->balance]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['success' => false, 'message' => 'Erreur de confirmation.'], 500);
        }
    }
}
