<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * PHASE 2: Remplir toutes les colonnes UUID
     * Cette migration génère et assigne un UUID unique à chaque enregistrement existant.
     */
    public function up(): void
    {
        // Tables - ordre n'est pas critique ici car on ne modifie que la colonne uuid
        $tables = [
            'users',
            'events',
            'identity_verifications',
            'wallets',
            'registrations',
            'event_payments',
            'challenges',
            'participants',
            'chat_messages',
            'event_reviews',
            'tickets',
            'wallet_transactions',
            'identity_verification_logs',
            'votes',
            'donations',
            'ticket_transfers',
        ];

        foreach ($tables as $table) {
            // Vérifier que la table existe avant de la traiter
            if (!Schema::hasTable($table)) {
                continue;
            }

            // Récupérer tous les IDs et générer un UUID pour chacun
            $records = DB::table($table)->select('id')->get();
            
            foreach ($records as $record) {
                DB::table($table)
                    ->where('id', $record->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        }

        // Table settings (si elle existe)
        if (Schema::hasTable('settings')) {
            $records = DB::table('settings')->select('id')->get();
            foreach ($records as $record) {
                DB::table('settings')
                    ->where('id', $record->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            }
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Remet tous les UUID à NULL
     */
    public function down(): void
    {
        $tables = [
            'users', 'events', 'identity_verifications', 'wallets',
            'registrations', 'event_payments', 'challenges', 'participants',
            'chat_messages', 'event_reviews', 'tickets', 'wallet_transactions',
            'identity_verification_logs', 'votes', 'donations', 'ticket_transfers',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->update(['uuid' => null]);
            }
        }

        if (Schema::hasTable('settings')) {
            DB::table('settings')->update(['uuid' => null]);
        }
    }
};
