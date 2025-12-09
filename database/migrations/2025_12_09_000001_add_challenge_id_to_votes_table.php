<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (!Schema::hasColumn('votes', 'challenge_id')) {
                $table->foreignId('challenge_id')->nullable()->constrained()->nullOnDelete();
                $table->index(['event_id', 'challenge_id']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            if (Schema::hasColumn('votes', 'challenge_id')) {
                // Drop composite index if it exists (conventional name)
                try { $table->dropIndex('votes_event_id_challenge_id_index'); } catch (\Throwable $e) {}
                $table->dropConstrainedForeignId('challenge_id');
            }
        });
    }
};
