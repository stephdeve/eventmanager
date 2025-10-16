<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('shareable_link')->nullable()->after('cover_image');
            $table->unsignedInteger('promo_clicks')->default(0)->after('shareable_link');
            $table->unsignedInteger('promo_registrations')->default(0)->after('promo_clicks');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'shareable_link', 'promo_clicks', 'promo_registrations']);
        });
    }
};
