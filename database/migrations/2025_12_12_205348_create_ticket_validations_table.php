<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_validations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('validation_date'); // Date de validation (sans heure)
            $table->timestamp('validated_at'); // Timestamp complet
            $table->string('validation_method')->default('scan'); // scan, manual, etc.
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index unique: un ticket ne peut être validé qu'une fois par date
            $table->unique(['ticket_id', 'validation_date'], 'ticket_validation_unique');
            
            // Index pour requêtes fréquentes
            $table->index('validation_date');
            $table->index(['ticket_id', 'validation_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_validations');
    }
};
