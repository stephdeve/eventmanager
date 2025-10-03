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
        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('registrations', 'qr_code_png_path')) {
                $table->string('qr_code_png_path')->nullable()->after('qr_code_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (Schema::hasColumn('registrations', 'qr_code_png_path')) {
                $table->dropColumn('qr_code_png_path');
            }
        });
    }
};
