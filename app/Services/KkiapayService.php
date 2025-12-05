<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventPayment;
use App\Models\Ticket;
use App\Models\Registration;
use App\Services\QrCodeService;
use App\Support\Currency as AppCurrency;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KkiapayService
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function verify(string $transactionId): array
    {
        $sandbox = (bool) config('services.kkiapay.sandbox', true);
        $configured = trim((string) config('services.kkiapay.api_url', ''));
        // Choisir la bonne base selon l'environnement si non explicitement configuré
        if ($configured !== '') {
            $apiUrl = rtrim($configured, '/');
        } else {
            $apiUrl = $sandbox ? 'https://api-sandbox.kkiapay.me' : 'https://api.kkiapay.me';
        }
        // Sécurité: si sandbox=true mais un host prod est configuré, forcer sandbox
        if ($sandbox && str_contains($apiUrl, 'api.kkiapay.me')) {
            $apiUrl = 'https://api-sandbox.kkiapay.me';
        }
        // Endpoint conforme au SDK PHP officiel (avec repli automatique si 404)
        $primaryUrl = $apiUrl . '/api/v1/transactions/status';
        $fallbackUrl = $apiUrl . '/api/v1/transactions/verify';

        $request = Http::withHeaders([
            // Aligner les noms d'en-têtes sur le SDK (insensibles à la casse, mais on garde la convention)
            'X-API-KEY' => config('services.kkiapay.public_key'),
            'X-PRIVATE-KEY' => config('services.kkiapay.private_key'),
            'X-SECRET-KEY' => config('services.kkiapay.secret'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->asJson();

        // Environnement de développement: désactiver la vérification SSL pour contourner cURL error 60
        if (app()->isLocal() || config('app.debug')) {
            $request = $request->withoutVerifying();
        }

        $payload = ['transactionId' => $transactionId];

        $response = $request->post($primaryUrl, $payload);

        // Repli si l'endpoint principal n'existe pas / n'est pas supporté
        if (in_array($response->status(), [404, 405], true)) {
            Log::info('Kkiapay verify: primary endpoint failed, trying fallback', [
                'status' => $response->status(),
                'primary' => $primaryUrl,
                'fallback' => $fallbackUrl,
            ]);
            $response = $request->post($fallbackUrl, $payload);
        }

        if (!$response->successful()) {
            Log::warning('Kkiapay verify failed', [
                'sandbox' => $sandbox,
                'api_url' => $apiUrl,
                'attempted' => [$primaryUrl, $fallbackUrl],
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers(),
            ]);
            $response->throw();
        }

        return $response->json();
    }

    public function confirmPayment(Registration $registration, string $transactionId): bool
    {
        $data = $this->verify($transactionId);

        $status = strtoupper((string) (Arr::get($data, 'status') ?? Arr::get($data, 'state') ?? ''));
        $isSuccess = in_array($status, ['SUCCESS', 'SUCCESSFUL', 'COMPLETED'], true);

        if (!$isSuccess) {
            return false;
        }

        // Normalize amount & currency
        $currency = strtoupper((string) (Arr::get($data, 'currency') ?? Arr::get($data, 'monetaryCurrency') ?? ($registration->event->currency ?? 'XOF')));
        $amountMajor = (float) (Arr::get($data, 'amount') ?? Arr::get($data, 'monetaryAmount') ?? 0);
        $ticketsCount = max(1, (int) ($registration->quantity ?? 1));
        $amountMinor = $amountMajor > 0
            ? AppCurrency::toMinorUnits($amountMajor, $currency)
            : (int) $registration->event->price * $ticketsCount;
        $method = (string) (Arr::get($data, 'paymentMethod') ?? Arr::get($data, 'method') ?? Arr::get($data, 'channel') ?? 'card');

        DB::transaction(function () use ($registration, $transactionId, $data, $currency, $amountMinor, $method) {
            // Update registration
            $registration->forceFill([
                'payment_status' => 'paid',
                'payment_reference' => $transactionId,
                'paid_at' => now(),
                'payment_metadata' => $data,
            ])->save();

            // Mark related tickets as paid (online numeric payment)
            try {
                Ticket::where('registration_id', $registration->id)
                    ->update([
                        'paid' => true,
                        'payment_method' => 'numeric',
                    ]);
            } catch (\Throwable $e) {
                Log::warning('Failed to mark tickets as paid after Kkiapay confirmation', [
                    'registration_id' => $registration->id,
                    'error' => $e->getMessage(),
                ]);
            }

            // Generate QR code if missing
            if (!$registration->qr_code_path) {
                $qrCodeData = route('registrations.show', $registration->qr_code_data);
                $qrCodePaths = $this->qrCodeService->generate($qrCodeData);
                $registration->forceFill([
                    'qr_code_path' => $qrCodePaths['svg'] ?? null,
                    'qr_code_png_path' => $qrCodePaths['png'] ?? null,
                ])->save();
            }

            // Create or update payment record idempotently
            $event = $registration->event()->lockForUpdate()->first();
            $payment = EventPayment::where('provider', 'kkiapay')
                ->where('provider_reference', $transactionId)
                ->first();

            $wasAlreadySuccess = $payment && $payment->status === 'success';
            if (!$payment) {
                $payment = EventPayment::create([
                    'user_id' => $registration->user_id,
                    'event_id' => $event->id,
                    'registration_id' => $registration->id,
                    'provider' => 'kkiapay',
                    'provider_reference' => $transactionId,
                    'method' => $method,
                    'status' => 'success',
                    'amount_minor' => $amountMinor,
                    'currency' => $currency,
                    'paid_at' => now(),
                    'metadata' => $data,
                ]);
            } elseif (!$wasAlreadySuccess) {
                $payment->forceFill([
                    'status' => 'success',
                    'amount_minor' => $amountMinor,
                    'currency' => $currency,
                    'method' => $method,
                    'paid_at' => $payment->paid_at ?: now(),
                    'metadata' => $data,
                ])->save();
            }

            // Update event totals once (only if newly counted)
            if (!$wasAlreadySuccess) {
                $prevRevenue = (int) ($event->total_revenue_minor ?? 0);
                $event->increment('total_revenue_minor', $amountMinor);
                $ticketsCount = (int) ($registration->quantity ?? 1);
                if ($ticketsCount < 1) { $ticketsCount = 1; }
                $event->increment('total_tickets_sold', $ticketsCount);

                // Threshold notification
                $threshold = (int) ($event->revenue_threshold_minor ?? 0);
                if ($threshold > 0 && !$event->revenue_threshold_notified_at && $prevRevenue < $threshold && ($prevRevenue + $amountMinor) >= $threshold) {
                    try {
                        $event->loadMissing('organizer');
                        if ($event->organizer) {
                            $event->organizer->notify(new \App\Notifications\OrganizerRevenueThresholdReached($event));
                        }
                        $event->forceFill(['revenue_threshold_notified_at' => now()])->save();
                    } catch (\Throwable $e) {
                        Log::warning('Threshold notify failed', ['event_id' => $event->id, 'error' => $e->getMessage()]);
                    }
                }
            }
        });

        return true;
    }

    /**
     * Record a refund and update event totals accordingly (idempotent per provider reference).
     */
    public function recordRefund(string $providerReference, ?int $amountMinor = null): bool
    {
        return DB::transaction(function () use ($providerReference, $amountMinor) {
            $payment = EventPayment::where('provider', 'kkiapay')
                ->where('provider_reference', $providerReference)
                ->lockForUpdate()
                ->first();
            if (!$payment) {
                return false;
            }
            if ($payment->status === 'refunded') {
                return true; // idempotent
            }
            $amount = $amountMinor ?? (int) $payment->amount_minor;
            $payment->forceFill([
                'status' => 'refunded',
                'refunded_at' => now(),
            ])->save();

            $event = Event::lockForUpdate()->find($payment->event_id);
            if ($event) {
                $event->decrement('total_revenue_minor', $amount);
            }

            return true;
        });
    }
}
