<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['tickets', 'wallet_transactions', 'identity_verification_logs', 'votes', 'donations'];

        foreach ($tables as $table) {
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
        foreach (['tickets', 'wallet_transactions', 'identity_verification_logs', 'votes', 'donations'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropPrimary();
                $t->renameColumn('id', 'uuid');
                $t->id()->first();
            });
        }
    }
};
