<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PHASE 3: Switch PK - users (ROOT TABLE - FIRST!)
     */
    public function up(): void
    {
        // Step 1: Remove AUTO_INCREMENT from id column
        DB::statement('ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL');
        
        // Step 2: Drop primary key
        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary();
        });

        // Step 3: Drop old id, rename uuid to id
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->renameColumn('uuid', 'id');
        });

        // Step 4: Set new id as primary key
        Schema::table('users', function (Blueprint $table) {
            $table->primary('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary();
            $table->renameColumn('id', 'uuid');
            $table->id()->first();
        });
    }
};
