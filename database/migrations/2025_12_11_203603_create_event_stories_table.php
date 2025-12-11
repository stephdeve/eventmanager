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
        Schema::create('event_stories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('video_path'); // storage path to video file
            $table->string('thumbnail_path')->nullable(); // auto-generated thumbnail
            $table->integer('duration')->default(0); // duration in seconds
            $table->integer('order')->default(0); // display order
            $table->boolean('is_active')->default(false); // published or draft
            $table->bigInteger('views_count')->default(0); // number of views
            $table->timestamps();

            // Indexes for performance
            $table->index(['event_id', 'is_active', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_stories');
    }
};
