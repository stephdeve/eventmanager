<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventStory;

class StoryTestSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        
        if (!$event) {
            $this->command->error('Aucun événement trouvé !');
            return;
        }

        // Create 3 test stories with YouTube URLs
        $youtubeVideos = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Rick Roll
            'https://www.youtube.com/watch?v=jNQXAC9IVRw', // Me at the zoo
            'https://youtu.be/9bZkp7q19f0', // Gangnam Style (short URL)
        ];

        foreach ($youtubeVideos as $index => $url) {
            EventStory::create([
                'event_id' => $event->id,
                'video_type' => EventStory::TYPE_URL,
                'external_url' => $url,
                'platform' => EventStory::PLATFORM_YOUTUBE,
                'video_path' => null,
                'duration' => 30,
                'order' => $index,
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ 3 stories de test créées pour: ' . $event->title);
    }
}
