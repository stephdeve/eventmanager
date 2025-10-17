<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('qr_code_data')->unique();
            $table->string('qr_code_path')->nullable();
            $table->string('qr_code_png_path')->nullable();
            $table->string('status')->default('valid'); // valid, used, invalid
            $table->boolean('paid')->default(false);
            $table->string('payment_method')->nullable(); // numeric, physical
            $table->timestamp('scanned_at')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable();
            $table->string('transferred_to')->nullable(); // email or identifier of recipient (for auditing)
            $table->timestamps();

            $table->index(['event_id']);
            $table->index(['registration_id']);
            $table->index(['owner_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
