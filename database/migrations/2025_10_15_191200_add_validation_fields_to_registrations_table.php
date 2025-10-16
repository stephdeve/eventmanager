<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('registrations', 'validated_at')) {
                $table->timestamp('validated_at')->nullable()->after('is_validated');
            }
            if (!Schema::hasColumn('registrations', 'validated_by')) {
                $table->foreignId('validated_by')->nullable()->after('validated_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (Schema::hasColumn('registrations', 'validated_by')) {
                $table->dropConstrainedForeignId('validated_by');
            }
            if (Schema::hasColumn('registrations', 'validated_at')) {
                $table->dropColumn('validated_at');
            }
        });
    }
};
