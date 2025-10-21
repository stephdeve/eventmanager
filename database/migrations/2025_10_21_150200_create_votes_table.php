<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('value')->default(1);
            $table->string('vote_type', 20)->default('free');
            $table->timestamps();
            $table->index(['user_id','participant_id','event_id','vote_type','created_at'], 'votes_user_participant_day_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
