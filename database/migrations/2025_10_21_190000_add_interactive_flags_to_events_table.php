<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_interactive')->default(false)->after('tiktok_url');
            $table->boolean('interactive_public')->default(false)->after('is_interactive');
            $table->timestamp('interactive_starts_at')->nullable()->after('interactive_public');
            $table->timestamp('interactive_ends_at')->nullable()->after('interactive_starts_at');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'is_interactive',
                'interactive_public',
                'interactive_starts_at',
                'interactive_ends_at',
            ]);
        });
    }
};
