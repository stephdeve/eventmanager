<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Switch PK - Level 2 tables (depend on users + events)
     */
    public function up(): void
    {
        $tables = ['registrations', 'event_payments', 'challenges', 'participants', 'chat_messages', 'event_reviews'];

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
        $tables = ['registrations', 'event_payments', 'challenges', 'participants', 'chat_messages', 'event_reviews'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropPrimary();
                $t->renameColumn('id', 'uuid');
                $t->id()->first();
            });
        }
    }
};
