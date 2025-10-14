<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('is_validated');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->string('payment_session_url')->nullable()->after('payment_reference');
            $table->timestamp('paid_at')->nullable()->after('payment_session_url');
            $table->json('payment_metadata')->nullable()->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_reference',
                'payment_session_url',
                'paid_at',
                'payment_metadata',
            ]);
        });
    }
};
