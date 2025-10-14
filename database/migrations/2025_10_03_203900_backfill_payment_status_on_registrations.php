<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('registrations')
            ->where('is_validated', true)
            ->update([
                'payment_status' => 'paid',
                'paid_at' => DB::raw('coalesce(paid_at, updated_at, created_at)'),
                'payment_metadata' => DB::raw("json_set(coalesce(payment_metadata, '{}'), '$.backfill', 'validated')"),
            ]);

        DB::table('registrations')
            ->where('is_validated', false)
            ->whereNull('paid_at')
            ->update([
                'payment_status' => DB::raw("case when payment_status = 'paid' then 'paid' else 'pending' end"),
            ]);
    }

    public function down(): void
    {
        DB::table('registrations')
            ->whereJsonContains('payment_metadata->backfill', 'validated')
            ->update([
                'payment_status' => 'pending',
                'paid_at' => null,
                'payment_metadata' => DB::raw("json_remove(payment_metadata, '$.backfill')"),
            ]);
    }
};
