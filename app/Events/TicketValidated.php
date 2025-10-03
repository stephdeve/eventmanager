<?php

namespace App\Events;

use App\Models\Registration;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketValidated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(public Registration $registration)
    {
        $this->registration->loadMissing(['event', 'user']);
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('events.' . $this->registration->event_id);
    }

    public function broadcastAs(): string
    {
        return 'ticket.validated';
    }

    public function broadcastWith(): array
    {
        return [
            'registration_id' => $this->registration->id,
            'event' => [
                'id' => $this->registration->event->id,
                'title' => $this->registration->event->title,
            ],
            'attendee' => [
                'id' => $this->registration->user->id,
                'name' => $this->registration->user->name,
                'email' => $this->registration->user->email,
            ],
            'validated_at' => optional($this->registration->validated_at)->toIso8601String(),
        ];
    }
}
