<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * NOW all PKs are UUID! Update FK sessions.user_id
     */
    public function up(): void
    {
        // sessions table might not have FK defined, check first
        DB::unprepared('
            SET @fk = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "sessions" 
                AND COLUMN_NAME = "user_id" AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1);
            SET @sql = IF(@fk IS NOT NULL, CONCAT("ALTER TABLE sessions DROP FOREIGN KEY ", @fk), "SELECT 1");
            PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
        ');

        Schema::table('sessions', function (Blueprint $table) {
            $table->string('user_id_uuid', 36)->nullable()->after('user_id');
        });

        DB::statement('UPDATE sessions s INNER JOIN users u ON s.user_id = u.id SET s.user_id_uuid = u.id WHERE s.user_id IS NOT NULL');

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->renameColumn('user_id_uuid', 'user_id');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Rollback logic
    }
};
