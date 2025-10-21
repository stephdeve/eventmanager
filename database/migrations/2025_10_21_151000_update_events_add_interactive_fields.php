<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'status')) {
                $table->string('status', 20)->default('draft')->after('end_date');
            }
            if (!Schema::hasColumn('events', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('events', 'tiktok_url')) {
                $table->string('tiktok_url')->nullable()->after('youtube_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('events', 'youtube_url')) {
                $table->dropColumn('youtube_url');
            }
            if (Schema::hasColumn('events', 'tiktok_url')) {
                $table->dropColumn('tiktok_url');
            }
        });
    }
};
