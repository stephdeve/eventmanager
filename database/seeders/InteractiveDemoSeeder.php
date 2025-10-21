<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class InteractiveDemoSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::first() ?? User::factory()->create();

        $event = Event::firstOrCreate(
            ['slug' => 'house-of-challenge-demo'],
            [
                'title' => 'House of Challenge – Démo',
                'description' => "Événement interactif de démonstration avec votes, classement et communauté.",
                'start_date' => Carbon::now()->subHour(),
                'end_date' => Carbon::now()->addDays(2),
                'location' => 'En ligne',
                'capacity' => 1000,
                'available_seats' => 1000,
                'is_capacity_unlimited' => true,
                'price' => 0,
                'currency' => 'XOF',
                'cover_image' => null,
                'organizer_id' => $organizer->id,
                'status' => 'running',
                'youtube_url' => null,
                'tiktok_url' => null,
            ]
        );

        // Activer l'expérience interactive pour la démo (lecture publique)
        $event->fill([
            'is_interactive' => true,
            'interactive_public' => true,
            'interactive_starts_at' => Carbon::now()->subHour(),
            'interactive_ends_at' => Carbon::now()->addDays(2),
        ])->save();

        $participants = collect([
            ['name' => 'Aïcha', 'country' => 'BJ'],
            ['name' => 'Kwame', 'country' => 'GH'],
            ['name' => 'Fatou', 'country' => 'SN'],
            ['name' => 'Yemi', 'country' => 'NG'],
            ['name' => 'Zina', 'country' => 'CI'],
        ])->map(function ($row) use ($event) {
            return Participant::firstOrCreate([
                'event_id' => $event->id,
                'name' => $row['name'],
            ], [
                'country' => $row['country'],
                'photo_path' => null,
                'bio' => null,
                'video_url' => null,
                'score_total' => 0,
            ]);
        });

        // 30 votes aléatoires
        for ($i = 0; $i < 30; $i++) {
            $p = $participants->random();
            Vote::create([
                'user_id' => $organizer->id,
                'participant_id' => $p->id,
                'event_id' => $event->id,
                'value' => 1,
                'vote_type' => 'free',
            ]);
            $p->increment('score_total');
        }
    }
}
