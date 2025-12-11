<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * CRITICAL: Drop ALL foreign keys BEFORE switching PKs
     * MySQL doesn't allow modifying columns when they're referenced by FK
     */
    public function up(): void
    {
        // Get all FK constraints dynamically
        $fks = DB::select("
            SELECT TABLE_NAME, CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        foreach ($fks as $fk) {
            try {
                DB::statement("ALTER TABLE `{$fk->TABLE_NAME}` DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            } catch (\Exception $e) {
                // FK might not exist, continue
            }
        }
    }

    public function down(): void
    {
        // FK will be recreated in later migrations
    }
};
