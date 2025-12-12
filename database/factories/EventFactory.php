<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug,
            'organizer_id' => \App\Models\User::factory(),
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'location' => $this->faker->address,
            'description' => $this->faker->paragraph,
            'price' => 1000,
            'currency' => 'XOF',
            'capacity' => 100,
            'status' => 'published',
            'event_type' => 'public',
        ];
    }
}
