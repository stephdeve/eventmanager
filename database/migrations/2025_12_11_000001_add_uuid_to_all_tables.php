<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * PHASE 1: Ajouter la colonne UUID à toutes les tables
     * Cette migration ajoute une colonne 'uuid' (nullable temporairement) à toutes les tables
     * qui ont actuellement une clé primaire auto-incrémentée.
     */
    public function up(): void
    {
        // Niveau 0 - Table racine
        Schema::table('users', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        // Niveau 1 - Dépendent de users
        Schema::table('events', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        // Niveau 2 - Dépendent de users + events
        Schema::table('registrations', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('event_payments', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('event_reviews', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        // Niveau 3 - Dépendent de registrations/participants
        Schema::table('tickets', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('identity_verification_logs', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('votes', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        // Niveau 4 - Dépendent de tickets
        Schema::table('ticket_transfers', function (Blueprint $table) {
            $table->char('uuid', 36)->nullable()->after('id');
        });

        // Tables système
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->char('uuid', 36)->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('identity_verifications', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('event_payments', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('challenges', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('event_reviews', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('identity_verification_logs', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('ticket_transfers', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
};
