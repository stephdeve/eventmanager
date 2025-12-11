<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * CRITICAL FIX: Convert all FK columns from BIGINT to CHAR(36) to store UUIDs
     */
    public function up(): void
    {
        // List of all FK columns that need to be converted to CHAR(36)
        $conversions = [
            // Table => [column1, column2, ...]
            'sessions' => ['user_id'],
            'events' => ['organizer_id'],
            'wallets' => ['user_id'],
            'identity_verifications' => ['user_id', 'reviewed_by'],
            'registrations' => ['user_id', 'event_id', 'validated_by'],
            'event_payments' => ['user_id', 'event_id', 'registration_id'],
            'challenges' => ['event_id'],
            'participants' => ['event_id'],
            'chat_messages' => ['event_id', 'user_id'],
            'event_reviews' => ['event_id', 'user_id'],
            'tickets' => ['event_id', 'registration_id', 'owner_user_id', 'validated_by'],
            'wallet_transactions' => ['user_id'],
            'identity_verification_logs' => ['identity_verification_id', 'performed_by'],
            'votes' => ['user_id', 'participant_id', 'event_id', 'challenge_id'],
            'donations' => ['user_id', 'participant_id'],
            'ticket_transfers' => ['ticket_id', 'from_user_id', 'to_user_id', 'performed_by'],
        ];

        foreach ($conversions as $table => $columns) {
            foreach ($columns as $column) {
                try {
                    // Check if column exists and is not already CHAR
                    $columnType = DB::select("
                        SELECT DATA_TYPE 
                        FROM information_schema.COLUMNS 
                        WHERE TABLE_SCHEMA = DATABASE() 
                        AND TABLE_NAME = '{$table}' 
                        AND COLUMN_NAME = '{$column}'
                    ");

                    if (!empty($columnType) && $columnType[0]->DATA_TYPE !== 'char') {
                        DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` CHAR(36) NULL");
                        echo "✅ Converted {$table}.{$column} to CHAR(36)\n";
                    }
                } catch (\Exception $e) {
                    // Column might not exist in this setup
                    echo "⚠️  Skipped {$table}.{$column}: {$e->getMessage()}\n";
                }
            }
        }
    }

    public function down(): void
    {
        // Rollback would require knowing original types
        // Not recommended to rollback after UUID conversion
    }
};
