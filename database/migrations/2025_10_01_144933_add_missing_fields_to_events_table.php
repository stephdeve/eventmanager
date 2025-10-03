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
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('event_date', 'start_date');
            $table->dateTime('end_date')->after('start_date');
            $table->integer('capacity')->default(0)->after('available_seats');
            $table->integer('price')->default(0)->after('capacity');
            $table->string('cover_image')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('start_date', 'event_date');
            $table->dropColumn([
                'end_date',
                'capacity',
                'price',
                'cover_image'
            ]);
        });
    }
};
