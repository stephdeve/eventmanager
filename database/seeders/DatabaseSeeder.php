<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@eventmanager.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Organisateur
        User::create([
            'name' => 'Organisateur Demo',
            'email' => 'organisateur@eventmanager.com',
            'password' => Hash::make('password'),
            'role' => 'organizer',
            'subscription_plan' => 'premium',
            'subscription_status' => 'active',
            'subscription_started_at' => now(),
            'subscription_expires_at' => now()->addYear(),
            'email_verified_at' => now(),
        ]);

        // Participant/Student
        User::create([
            'name' => 'Participant Demo',
            'email' => 'participant@eventmanager.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ 3 utilisateurs créés avec succès !');
        $this->command->info('📧 Admin: admin@eventmanager.com');
        $this->command->info('📧 Organisateur: organisateur@eventmanager.com');
        $this->command->info('📧 Participant: participant@eventmanager.com');
        $this->command->info('🔑 Mot de passe pour tous: password');
    }
}
