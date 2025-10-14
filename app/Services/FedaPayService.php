<?php

namespace App\Services;

use App\Models\Registration;
use App\Support\Currency as AppCurrency;
use Exception;
use FedaPay\Error\FedaPayException as BaseFedaPayException;
use FedaPay\Error\SignatureVerification as FedaPaySignatureException;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use FedaPay\Webhook;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FedaPayService
{
    public function __construct()
    {
        FedaPay::setApiKey(config('services.fedapay.secret_key'));
        FedaPay::setEnvironment(config('services.fedapay.environment', 'sandbox'));

        if ($apiBase = config('services.fedapay.api_url')) {
            FedaPay::setApiBase($apiBase);
        }
    }

    /**
     * Crée une transaction FedaPay et retourne les informations de session.
     *
     * @param  Registration  $registration
     * @return array{transaction: \FedaPay\Transaction, token: \FedaPay\FedaPayObject}
     *
     * @throws BaseFedaPayException
     */
    public function createPaymentSession(Registration $registration): array
    {
        $event = $registration->event()->firstOrFail();
        $user = $registration->user()->firstOrFail();

        // Montant stocké en "minor units" en base. Convertissons en unités majeures selon la devise.
        $rawAmountMinor = (int) $event->price;
        $eventCurrency = strtoupper($event->currency ?? 'XOF');
        $currencyIso = $eventCurrency;
        // FedaPay supported ISO codes (as of sandbox API): XOF, XAF, GNF
        $supportedIsos = ['XOF', 'XAF', 'GNF'];
        if (!in_array($currencyIso, $supportedIsos, true)) {
            $currencyIso = 'XOF';
        }
        // Always compute major amount from the EVENT currency exponent
        $amount = max(1, (int) round(AppCurrency::toMajorUnits($rawAmountMinor, $eventCurrency)));

        $payload = [
            'description' => sprintf('Billet pour "%s"', $event->title),
            'amount' => $amount,
            'currency' => ['iso' => $currencyIso],
            'metadata' => [
                'registration_id' => $registration->id,
                'event_id' => $event->id,
                'user_id' => $user->id,
                'event_price_minor' => $rawAmountMinor,
                'event_currency' => $eventCurrency,
                'transaction_currency' => $currencyIso,
            ],
            'customer' => array_filter([
                'name' => $user->name,
                'email' => $user->email,
            ]),
            'reference' => Str::upper(Str::random(12)),
        ];

        if ($callback = config('services.fedapay.callback_url')) {
            $payload['callback_url'] = $callback;
        }

        $transaction = Transaction::create($payload);

        $token = $transaction->generateToken();

        return [
            'transaction' => $transaction->toArray(),
            'token' => [
                'token' => $token->token ?? null,
                'url' => $token->url ?? null,
            ],
        ];
    }

    /**
     * Rafraîchit le statut de paiement à partir de l'API FedaPay.
     */
    public function refreshPaymentStatus(Registration $registration): Registration
    {
        $metadata = $registration->payment_metadata ?? [];
        $transactionId = Arr::get($metadata, 'transaction_id');

        if (!$transactionId && $registration->payment_reference) {
            $transactionId = $registration->payment_reference;
        }

        if (!$transactionId) {
            return $registration;
        }

        try {
            $transaction = Transaction::retrieve($transactionId);
        } catch (BaseFedaPayException $exception) {
            Log::warning('FedaPay - impossible de récupérer la transaction', [
                'registration_id' => $registration->id,
                'transaction_id' => $transactionId,
                'error' => $exception->getMessage(),
            ]);

            return $registration;
        }

        $status = $transaction->status;
        $updates = [
            'payment_status' => $status,
            'payment_reference' => $transaction->id,
            'payment_metadata' => array_merge($metadata, [
                'transaction' => $transaction->toArray(),
            ]),
        ];

        if ($transaction->wasPaid()) {
            $updates['payment_status'] = 'paid';
            $updates['paid_at'] = now();
        }

        $registration->fill($updates)->save();

        return $registration->refresh();
    }

    /**
     * Traite un webhook FedaPay et met à jour l'inscription associée.
     */
    public function handleWebhookPayload(string $payload, ?string $signature = null): void
    {
        $secret = config('services.fedapay.webhook_secret');

        if ($secret) {
            try {
                $event = Webhook::constructEvent($payload, (string) $signature, $secret);
            } catch (FedaPaySignatureException $exception) {
                Log::warning('FedaPay webhook signature invalide', ['message' => $exception->getMessage()]);
                return;
            } catch (Exception $exception) {
                Log::warning('FedaPay webhook payload invalide', ['message' => $exception->getMessage()]);
                return;
            }

            $data = $event->data ?? [];
        } else {
            $data = json_decode($payload, true) ?? [];
        }

        $registrationId = Arr::get($data, 'metadata.registration_id')
            ?? Arr::get($data, 'data.metadata.registration_id');

        if (!$registrationId) {
            Log::info('FedaPay webhook ignoré: registration_id manquant', ['payload' => $data]);
            return;
        }

        $registration = Registration::find($registrationId);

        if (!$registration) {
            Log::info('FedaPay webhook ignoré: inscription introuvable', ['registration_id' => $registrationId]);
            return;
        }

        $status = Arr::get($data, 'status') ?? Arr::get($data, 'data.status');
        $transactionId = Arr::get($data, 'id') ?? Arr::get($data, 'data.id');

        $updates = [
            'payment_status' => $status ?? $registration->payment_status,
            'payment_reference' => $transactionId ?? $registration->payment_reference,
            'payment_metadata' => array_merge($registration->payment_metadata ?? [], ['webhook' => $data]),
        ];

        if (in_array($status, ['approved', 'transferred', 'paid'], true)) {
            $updates['payment_status'] = 'paid';
            $updates['paid_at'] = now();
        }

        $registration->update($updates);
    }
}
