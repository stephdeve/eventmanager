<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function ensure(string $userId): Wallet
    {
        return Wallet::firstOrCreate(['user_id' => $userId], ['balance' => 0]);
    }

    public function credit(string $userId, int $amount, array $meta = []): Wallet
    {
        return DB::transaction(function () use ($userId, $amount, $meta) {
            $wallet = $this->ensure($userId);
            $wallet->increment('balance', $amount);
            WalletTransaction::create([
                'user_id' => $userId,
                'type' => 'credit',
                'amount' => $amount,
                'metadata' => $meta,
            ]);
            return $wallet->fresh();
        });
    }

    public function debit(string $userId, int $amount, array $meta = []): ?Wallet
    {
        return DB::transaction(function () use ($userId, $amount, $meta) {
            $wallet = $this->ensure($userId);
            if ($wallet->balance < $amount) {
                return null;
            }
            $wallet->decrement('balance', $amount);
            WalletTransaction::create([
                'user_id' => $userId,
                'type' => 'debit',
                'amount' => $amount,
                'metadata' => $meta,
            ]);
            return $wallet->fresh();
        });
    }

    public function getBalance(string $userId): int
    {
        $wallet = $this->ensure($userId);
        return (int) $wallet->balance;
    }

    public function hasBalance(string $userId, int $amount): bool
    {
        return $this->getBalance($userId) >= $amount;
    }
}
