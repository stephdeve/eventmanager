<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ticket_transfers')) {
            DB::statement('ALTER TABLE ticket_transfers MODIFY id BIGINT UNSIGNED NOT NULL');
            
            Schema::table('ticket_transfers', function (Blueprint $table) {
                $table->dropPrimary();
            });

            Schema::table('ticket_transfers', function (Blueprint $table) {
                $table->dropColumn('id');
                $table->renameColumn('uuid', 'id');
            });

            Schema::table('ticket_transfers', function (Blueprint $table) {
                $table->primary('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ticket_transfers')) {
            Schema::table('ticket_transfers', function (Blueprint $table) {
                $table->dropPrimary();
                $table->renameColumn('id', 'uuid');
                $table->id()->first();
            });
        }
    }
};
