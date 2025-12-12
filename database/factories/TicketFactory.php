<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event::factory(),
            'registration_id' => null,
            'owner_user_id' => \App\Models\User::factory(),
            'qr_code_data' => \Illuminate\Support\Str::uuid(),
            'status' => 'valid',
            'paid' => true,
            'payment_method' => 'numeric',
        ];
    }
}
