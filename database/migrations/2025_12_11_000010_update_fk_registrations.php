<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Update registrations FK (user_id, event_id, validated_by)
     */
    public function up(): void
    {
        // Drop all FK first
        DB::unprepared('SET @fk1 = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "registrations" AND COLUMN_NAME = "user_id" AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1); SET @sql = IF(@fk1 IS NOT NULL, CONCAT("ALTER TABLE registrations DROP FOREIGN KEY ", @fk1), "SELECT 1"); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;');
        
        DB::unprepared('SET @fk2 = (SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "registrations" AND COLUMN_NAME = "event_id" AND REFERENCED_TABLE_NAME IS NOT NULL LIMIT 1); SET @sql = IF(@fk2 IS NOT NULL, CONCAT("ALTER TABLE registrations DROP FOREIGN KEY ", @fk2), "SELECT 1"); PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;');
        
        // Drop unique index if exists
        DB::unprepared('
            SET @idx = (SELECT INDEX_NAME FROM information_schema.STATISTICS 
                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = "registrations" 
                AND INDEX_NAME LIKE "%user_id%event_id%" LIMIT 1);
            SET @sql = IF(@idx IS NOT NULL, CONCAT("ALTER TABLE registrations DROP INDEX ", @idx), "SELECT 1");
            PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
        ');

        Schema::table('registrations', function (Blueprint $table) {
            $table->string('user_uuid', 36)->nullable()->after('user_id');
            $table->string('event_uuid', 36)->nullable()->after('event_id');
        });

        DB::statement('UPDATE registrations r INNER JOIN users u ON r.user_id = u.id SET r.user_uuid = u.id');
        DB::statement('UPDATE registrations r INNER JOIN events e ON r.event_id = e.id SET r.event_uuid = e.id');

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'event_id']);
            $table->renameColumn('user_uuid', 'user_id');
            $table->renameColumn('event_uuid', 'event_id');
            
            $table->unique(['user_id', 'event_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
        });
    }

    public function down(): void {}
};
