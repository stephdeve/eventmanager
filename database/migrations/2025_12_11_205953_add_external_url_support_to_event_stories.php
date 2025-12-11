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
        Schema::table('event_stories', function (Blueprint $table) {
            $table->string('video_type')->default('upload')->after('event_id');
            // 'upload' or 'url'
            
            $table->text('external_url')->nullable()->after('video_path');
            // URL from YouTube, TikTok, Instagram, etc.
            
            $table->string('platform')->nullable()->after('external_url');
            // youtube, tiktok, instagram, etc.
            
            // Make video_path nullable since external URLs don't need it
            $table->string('video_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_stories', function (Blueprint $table) {
            $table->dropColumn(['video_type', 'external_url', 'platform']);
            $table->string('video_path')->nullable(false)->change();
        });
    }
};
