<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketValidation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ticket_can_be_validated_for_the_first_time_today()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(2),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        $this->assertFalse($ticket->isValidatedToday());
        $this->assertTrue($ticket->canBeValidatedToday());

        $validation = $ticket->validateForToday($organizer);

        $this->assertInstanceOf(TicketValidation::class, $validation);
        $this->assertTrue($ticket->isValidatedToday());
        $this->assertEquals(today(), $validation->validation_date);
        $this->assertEquals($organizer->id, $validation->validated_by);
    }

    /** @test */
    public function ticket_cannot_be_validated_twice_on_same_day()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(2),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        // First validation
        $validation1 = $ticket->validateForToday($organizer);
        $this->assertInstanceOf(TicketValidation::class, $validation1);

        // Second validation attempt (same day)
        $this->assertTrue($ticket->isValidatedToday());
        $this->assertFalse($ticket->canBeValidatedToday());
        
        $validation2 = $ticket->validateForToday($organizer);
        $this->assertFalse($validation2);

        // Verify only one validation exists
        $this->assertEquals(1, $ticket->validations()->count());
    }

    /** @test */
    public function ticket_can_be_validated_on_different_days()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(2),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        // Validation on "yesterday" (simulated)
        $yesterdayValidation = TicketValidation::create([
            'ticket_id' => $ticket->id,
            'validated_by' => $organizer->id,
            'validation_date' => today()->subDay(),
            'validated_at' => now()->subDay(),
            'validation_method' => 'scan',
        ]);

        // Should not be validated today
        $this->assertFalse($ticket->isValidatedToday());
        $this->assertTrue($ticket->canBeValidatedToday());

        // Validate for today
        $todayValidation = $ticket->validateForToday($organizer);
        $this->assertInstanceOf(TicketValidation::class, $todayValidation);

        // Verify we have 2 validations
        $this->assertEquals(2, $ticket->validations()->count());
    }

    /** @test */
    public function ticket_cannot_be_validated_before_event_starts()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        $this->assertFalse($ticket->canBeValidatedToday());
        
        $validation = $ticket->validateForToday($organizer);
        $this->assertFalse($validation);
    }

    /** @test */
    public function ticket_cannot_be_validated_after_event_ends()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(2),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        $this->assertFalse($ticket->canBeValidatedToday());
        
        $validation = $ticket->validateForToday($organizer);
        $this->assertFalse($validation);
    }

    /** @test */
    public function invalid_ticket_cannot_be_validated()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(2),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'invalid',
            'paid' => true,
        ]);

        $this->assertFalse($ticket->canBeValidatedToday());
        
        $validation = $ticket->validateForToday($organizer);
        $this->assertFalse($validation);
    }

    /** @test */
    public function validation_history_is_tracked_correctly()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now()->subDays(3),
            'end_date' => now()->addDays(1),
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        // Create validations for 3 different days
        $dates = [
            today()->subDays(2),
            today()->subDay(),
            today(),
        ];

        foreach ($dates as $index => $date) {
            TicketValidation::create([
                'ticket_id' => $ticket->id,
                'validated_by' => $organizer->id,
                'validation_date' => $date,
                'validated_at' => $date->setTime(10 + $index, 0),
                'validation_method' => 'scan',
            ]);
        }

        $validations = $ticket->validations()->orderBy('validation_date', 'desc')->get();
        
        $this->assertEquals(3, $validations->count());
        $this->assertEquals(today(), $validations->first()->validation_date);
        $this->assertTrue($ticket->isValidatedToday());
    }

    /** @test */
    public function single_day_event_works_correctly()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        $event = Event::factory()->create([
            'organizer_id' => $organizer->id,
            'start_date' => now(),
            'end_date' => now(), // Same day
        ]);
        
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'status' => 'valid',
            'paid' => true,
        ]);

        $this->assertTrue($ticket->canBeValidatedToday());
        
        $validation = $ticket->validateForToday($organizer);
        $this->assertInstanceOf(TicketValidation::class, $validation);

        // Cannot validate again same day
        $this->assertFalse($ticket->canBeValidatedToday());
    }
}
