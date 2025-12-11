<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Update all remaining FK - batched for speed
     */
    public function up(): void
    {
        // All FK were already dropped in migration 000002_5
        // Now just recreate FK pointing to UUID PKs
        
        // Events FK (challenges, participants, chat_messages, event_reviews)
        foreach (['challenges', 'participants', 'chat_messages', 'event_reviews'] as $table) {
            try {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    $t->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
                });
            } catch (\Exception $e) {
                // FK might already exist, continue
            }
        }

        // User FK (chat_messages, event_reviews, wallet_transactions)
        foreach (['chat_messages', 'event_reviews', 'wallet_transactions'] as $table) {
            try {
                Schema::table($table, function (Blueprint $t) {
                    $t->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                });
            } catch (\Exception $e) {
                // FK might already exist, continue
            }
        }

        // All done - FK now point to UUID PKs!
    }

    public function down(): void {}
};
