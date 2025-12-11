<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PHASE 3: Switch PK - Level 1 tables (events, wallets, identity_verifications, settings)
     */
    public function up(): void
    {
        $tables = ['events', 'wallets', 'identity_verifications'];
        
        if (Schema::hasTable('settings')) {
            $tables[] = 'settings';
        }

        foreach ($tables as $table) {
            // Remove AUTO_INCREMENT first
            DB::statement("ALTER TABLE {$table} MODIFY id BIGINT UNSIGNED NOT NULL");
            
            Schema::table($table, function (Blueprint $t) {
                $t->dropPrimary();
            });

            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('id');
                $t->renameColumn('uuid', 'id');
            });

            Schema::table($table, function (Blueprint $t) {
                $t->primary('id');
            });
        }
    }

    public function down(): void
    {
        $tables = ['events', 'wallets', 'identity_verifications'];
        if (Schema::hasTable('settings')) {
            $tables[] = 'settings';
        }

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropPrimary();
                $t->renameColumn('id', 'uuid');
                $t->id()->first();
            });
        }
    }
};
