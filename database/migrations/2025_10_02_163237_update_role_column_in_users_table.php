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
        // Modifier la colonne role pour accepter 'admin' comme valeur valide
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('student', 'organizer', 'admin') NOT NULL DEFAULT 'student'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revenir à la définition précédente de la colonne role
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('student', 'organizer') NOT NULL DEFAULT 'student'");
    }
};
