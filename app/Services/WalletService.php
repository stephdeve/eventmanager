<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function ensure(int $userId): Wallet
    {
        return Wallet::firstOrCreate(['user_id' => $userId], ['balance' => 0]);
    }

    public function credit(int $userId, int $amount, array $meta = []): Wallet
    {
        return DB::transaction(function () use ($userId, $amount, $meta) {
            $wallet = $this->ensure($userId);
            $wallet->increment('balance', $amount);
            WalletTransaction::create([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => 'credit',
                'meta' => $meta,
            ]);
            return $wallet->refresh();
        });
    }

    public function debit(int $userId, int $amount, array $meta = []): bool
    {
        return DB::transaction(function () use ($userId, $amount, $meta) {
            $wallet = $this->ensure($userId);
            if ($wallet->balance < $amount) {
                return false;
            }
            $wallet->decrement('balance', $amount);
            WalletTransaction::create([
                'user_id' => $userId,
                'amount' => -$amount,
                'type' => 'debit',
                'meta' => $meta,
            ]);
            return true;
        });
    }
}
