<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventPayment;
use App\Models\Registration;
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
        $apiUrl = rtrim(config('services.kkiapay.api_url', 'https://api.kkiapay.me'), '/');
        $url = $apiUrl . '/api/v1/transactions/verify';

        $response = Http::withHeaders([
            'X-Api-Key' => config('services.kkiapay.public_key'),
            'X-Private-Key' => config('services.kkiapay.private_key'),
            'X-Secret-Key' => config('services.kkiapay.secret'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, [
            'transactionId' => $transactionId,
        ]);

        if (!$response->successful()) {
            Log::warning('Kkiapay verify failed', [
                'status' => $response->status(),
                'body' => $response->body(),
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
        $amountMinor = $amountMajor > 0 ? AppCurrency::toMinorUnits($amountMajor, $currency) : (int) $registration->event->price;
        $method = (string) (Arr::get($data, 'paymentMethod') ?? Arr::get($data, 'method') ?? Arr::get($data, 'channel') ?? 'card');

        DB::transaction(function () use ($registration, $transactionId, $data, $currency, $amountMinor, $method) {
            // Update registration
            $registration->forceFill([
                'payment_status' => 'paid',
                'payment_reference' => $transactionId,
                'paid_at' => now(),
                'payment_metadata' => $data,
            ])->save();

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
                $event->increment('total_tickets_sold', 1);

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
