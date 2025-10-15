<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->timestamp('reminder_j7_sent_at')->nullable()->after('payment_metadata');
            $table->timestamp('reminder_j1_sent_at')->nullable()->after('reminder_j7_sent_at');
            $table->timestamp('reminder_h3_sent_at')->nullable()->after('reminder_j1_sent_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('reminder_sub_j7_sent_at')->nullable()->after('subscription_expires_at');
            $table->timestamp('reminder_sub_j3_sent_at')->nullable()->after('reminder_sub_j7_sent_at');
            $table->timestamp('reminder_sub_j1_sent_at')->nullable()->after('reminder_sub_j3_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['reminder_j7_sent_at', 'reminder_j1_sent_at', 'reminder_h3_sent_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['reminder_sub_j7_sent_at', 'reminder_sub_j3_sent_at', 'reminder_sub_j1_sent_at']);
        });
    }
};
