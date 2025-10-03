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
        // Supprimer les événements sans date
        \App\Models\Event::whereNull('start_date')->orWhereNull('end_date')->delete();

        Schema::table('events', function (Blueprint $table) {
            // Rendre les champs de date obligatoires
            $table->dateTime('start_date')->nullable(false)->change();
            $table->dateTime('end_date')->nullable(false)->change();
            
            // Ajouter des contraintes pour s'assurer que les dates sont valides
            $table->dateTime('start_date')->after('description')->change();
            $table->dateTime('end_date')->after('start_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Rendre les champs de date à nouveau nullables pour le rollback
            $table->dateTime('start_date')->nullable()->change();
            $table->dateTime('end_date')->nullable()->change();
        });
    }
};
