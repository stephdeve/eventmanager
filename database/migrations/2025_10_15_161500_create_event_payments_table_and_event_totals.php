<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider')->index(); // e.g., kkiapay
            $table->string('provider_reference')->index(); // external transaction id
            $table->string('method')->nullable(); // card, mobile_money, etc.
            $table->string('status')->index(); // success, failed, pending, refunded
            $table->bigInteger('amount_minor');
            $table->string('currency', 3)->default('XOF');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['provider', 'provider_reference']);
        });

        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'total_revenue_minor')) {
                $table->bigInteger('total_revenue_minor')->default(0);
            }
            if (!Schema::hasColumn('events', 'total_tickets_sold')) {
                $table->unsignedBigInteger('total_tickets_sold')->default(0);
            }
            if (!Schema::hasColumn('events', 'revenue_threshold_minor')) {
                $table->bigInteger('revenue_threshold_minor')->nullable();
            }
            if (!Schema::hasColumn('events', 'revenue_threshold_notified_at')) {
                $table->timestamp('revenue_threshold_notified_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_payments');
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'total_revenue_minor')) $table->dropColumn('total_revenue_minor');
            if (Schema::hasColumn('events', 'total_tickets_sold')) $table->dropColumn('total_tickets_sold');
            if (Schema::hasColumn('events', 'revenue_threshold_minor')) $table->dropColumn('revenue_threshold_minor');
            if (Schema::hasColumn('events', 'revenue_threshold_notified_at')) $table->dropColumn('revenue_threshold_notified_at');
        });
    }
};
