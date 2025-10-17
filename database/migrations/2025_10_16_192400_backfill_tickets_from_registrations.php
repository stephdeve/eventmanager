<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        // Create tickets for existing registrations if none exist yet
        DB::table('registrations')
            ->orderBy('id')
            ->chunk(500, function ($rows) {
                foreach ($rows as $row) {
                    $ticketsExist = DB::table('tickets')->where('registration_id', $row->id)->exists();
                    if ($ticketsExist) { continue; }

                    $quantity = (int) ($row->quantity ?? 1);
                    if ($quantity < 1) { $quantity = 1; }

                    // Determine payment method and paid flag from registration
                    $paid = false;
                    $method = null;
                    $metadata = json_decode($row->payment_metadata ?? 'null', true) ?: [];
                    $mode = $metadata['mode'] ?? null;

                    if (($row->payment_status ?? 'pending') === 'paid') {
                        $paid = true;
                        if ($mode === 'free') { $method = 'free'; }
                        elseif ($mode === 'physical') { $method = 'physical'; }
                        else { $method = 'numeric'; }
                    } else {
                        if ($mode === 'physical') { $method = 'physical'; }
                        elseif ($mode === 'free') { $method = 'free'; }
                        else { $method = null; }
                    }

                    $inserts = [];
                    for ($i = 0; $i < $quantity; $i++) {
                        $inserts[] = [
                            'event_id' => $row->event_id,
                            'registration_id' => $row->id,
                            'owner_user_id' => $row->user_id,
                            'qr_code_data' => (string) Str::uuid(),
                            'status' => 'valid',
                            'paid' => $paid,
                            'payment_method' => $method,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (!empty($inserts)) {
                        DB::table('tickets')->insert($inserts);
                    }
                }
            });
    }

    public function down(): void
    {
        // No-op: do not remove backfilled tickets on rollback
    }
};
