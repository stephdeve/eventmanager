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
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('student')->after('email');
            });
            
            // Mettre à jour un utilisateur existant en tant qu'admin si nécessaire
            if (Schema::hasTable('users')) {
                $adminUser = DB::table('users')->first();
                if ($adminUser) {
                    DB::table('users')
                        ->where('id', $adminUser->id)
                        ->update(['role' => 'admin']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
