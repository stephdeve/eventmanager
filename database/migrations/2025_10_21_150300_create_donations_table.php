<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('amount_minor');
            $table->string('currency', 3)->default('XOF');
            $table->string('payment_method', 20);
            $table->string('status', 20)->default('pending');
            $table->string('reference')->unique();
            $table->timestamps();
            $table->index(['user_id','participant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
