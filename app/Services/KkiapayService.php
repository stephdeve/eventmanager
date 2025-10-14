<?php

namespace App\Services;

use App\Models\Registration;
use App\Support\Currency as AppCurrency;
use Illuminate\Support\Arr;
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

        $registration->update([
            'payment_status' => 'paid',
            'payment_reference' => $transactionId,
            'paid_at' => now(),
            'payment_metadata' => $data,
        ]);

        if (!$registration->qr_code_path) {
            $qrCodeData = route('registrations.show', $registration->qr_code_data);
            $qrCodePaths = $this->qrCodeService->generate($qrCodeData);

            $registration->update([
                'qr_code_path' => $qrCodePaths['svg'] ?? null,
                'qr_code_png_path' => $qrCodePaths['png'] ?? null,
            ]);
        }

        return true;
    }
}
