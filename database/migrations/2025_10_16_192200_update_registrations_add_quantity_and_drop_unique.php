<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
           if (!Schema::hasColumn('registrations', 'quantity')) {
               $table->unsignedInteger('quantity')->default(1)->after('event_id');
           }
       });

       // Ensure single-column indexes exist on user_id and event_id so MySQL doesn't rely on the
       // composite unique index to satisfy foreign key requirements (avoids error 1553 on drop)
       try {
           $hasUserIdx = false; $hasEventIdx = false;
           try {
               $indexes = DB::select("SHOW INDEX FROM `registrations`");
               foreach ($indexes as $idx) {
                   $key = isset($idx->Key_name) ? $idx->Key_name : (isset($idx->key_name) ? $idx->key_name : null);
                   if ($key === 'registrations_user_id_index' || $key === 'registrations_user_id_foreign') { $hasUserIdx = true; }
                   if ($key === 'registrations_event_id_index' || $key === 'registrations_event_id_foreign') { $hasEventIdx = true; }
               }
           } catch (\Throwable $e) { /* ignore detection errors, attempt creation */ }

           if (!$hasUserIdx) {
               Schema::table('registrations', function (Blueprint $table) {
                   try { $table->index('user_id'); } catch (\Throwable $e) { /* ignore duplicate */ }
               });
           }
           if (!$hasEventIdx) {
               Schema::table('registrations', function (Blueprint $table) {
                   try { $table->index('event_id'); } catch (\Throwable $e) { /* ignore duplicate */ }
               });
           }
       } catch (\Throwable $e) { /* ignore */ }

       // Drop unique index on (user_id, event_id) if it exists to allow multiple tickets/orders
       $indexName = 'registrations_user_id_event_id_unique';
       $hasIndex = false;
       try {
           $database = DB::getDatabaseName();
           $result = DB::select("SHOW INDEX FROM `registrations` WHERE Key_name = ?", [$indexName]);
           $hasIndex = !empty($result);
       } catch (\Throwable $e) {
           // Fallback: attempt drop directly
           $hasIndex = true;
       }
       if ($hasIndex) {
           // Try Laravel's dropUnique first
           Schema::table('registrations', function (Blueprint $table) use ($indexName) {
               try { $table->dropUnique($indexName); } catch (\Throwable $e) { /* ignore and try raw SQL below */ }
           });
           // As a fallback, attempt raw SQL drop (after ensuring single-column indexes)
           try { DB::statement("ALTER TABLE `registrations` DROP INDEX `$indexName`"); } catch (\Throwable $e) { /* ignore if already dropped */ }
       }
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (Schema::hasColumn('registrations', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });

        // Optionally restore unique constraint
        Schema::table('registrations', function (Blueprint $table) {
            try { $table->unique(['user_id', 'event_id']); } catch (\Throwable $e) { /* ignore */ }
        });
    }
};
