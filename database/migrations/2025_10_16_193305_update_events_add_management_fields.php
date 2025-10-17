<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            if (!Schema::hasColumn('events', 'google_maps_url')) {
                $table->string('google_maps_url')->nullable()->after('location');
            }
            if (!Schema::hasColumn('events', 'is_capacity_unlimited')) {
                $table->boolean('is_capacity_unlimited')->default(false)->after('capacity');
            }
            if (!Schema::hasColumn('events', 'daily_start_time')) {
                $table->time('daily_start_time')->nullable()->after('end_date');
            }
            if (!Schema::hasColumn('events', 'daily_end_time')) {
                $table->time('daily_end_time')->nullable()->after('daily_start_time');
            }
            if (!Schema::hasColumn('events', 'allow_payment_numeric')) {
                $table->boolean('allow_payment_numeric')->default(true)->after('currency');
            }
            if (!Schema::hasColumn('events', 'allow_payment_physical')) {
                $table->boolean('allow_payment_physical')->default(true)->after('allow_payment_numeric');
            }
            if (!Schema::hasColumn('events', 'allow_ticket_transfer')) {
                $table->boolean('allow_ticket_transfer')->default(false)->after('allow_payment_physical');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('events', 'google_maps_url')) {
                $table->dropColumn('google_maps_url');
            }
            if (Schema::hasColumn('events', 'is_capacity_unlimited')) {
                $table->dropColumn('is_capacity_unlimited');
            }
            if (Schema::hasColumn('events', 'daily_start_time')) {
                $table->dropColumn('daily_start_time');
            }
            if (Schema::hasColumn('events', 'daily_end_time')) {
                $table->dropColumn('daily_end_time');
            }
            if (Schema::hasColumn('events', 'allow_payment_numeric')) {
                $table->dropColumn('allow_payment_numeric');
            }
            if (Schema::hasColumn('events', 'allow_payment_physical')) {
                $table->dropColumn('allow_payment_physical');
            }
            if (Schema::hasColumn('events', 'allow_ticket_transfer')) {
                $table->dropColumn('allow_ticket_transfer');
            }
        });
    }
};
