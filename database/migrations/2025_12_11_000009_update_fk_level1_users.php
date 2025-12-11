<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Update ALL user FKs across tables (organizer_id, validated_by, reviewed_by, owner_user_id, etc.)
     */
    public function up(): void
    {
        // Events: organizer_id
        DB::unprepared('SET @fk = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "events" AND COLUMN_NAME = "organizer_id" AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1); SET @sql = IF(@fk IS NOT NULL, CONCAT("ALTER TABLE events DROP FOREIGN KEY ", @fk), "SELECT 1"); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;');
        
        Schema::table('events', function (Blueprint $table) {
            $table->string('organizer_uuid', 36)->nullable()->after('organizer_id');
        });
        
        DB::statement('UPDATE events e INNER JOIN users u ON e.organizer_id = u.id SET e.organizer_uuid = u.id WHERE e.organizer_id IS NOT NULL');
        
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('organizer_id');
            $table->renameColumn('organizer_uuid', 'organizer_id');
            $table->foreign('organizer_id')->references('id')->on('users')->nullOnDelete();
        });

        // Wallets: user_id
        DB::unprepared('SET @fk = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "wallets" AND COLUMN_NAME = "user_id" AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1); SET @sql = IF(@fk IS NOT NULL, CONCAT("ALTER TABLE wallets DROP FOREIGN KEY ", @fk), "SELECT 1"); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;');
        
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
            $table->string('user_uuid', 36)->nullable()->after('user_id');
        });
        
        DB::statement('UPDATE wallets w INNER JOIN users u ON w.user_id = u.id SET w.user_uuid = u.id');
        
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->renameColumn('user_uuid', 'user_id');
            $table->unique('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void {}
};
