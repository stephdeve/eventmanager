<?php

namespace App\Events;

use App\Models\Challenge;
use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChallengeStopped implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $afterCommit = true;

    public function __construct(
        public Event $event,
        public Challenge $challenge,
    ) {}

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('event.' . $this->event->id);
    }

    public function broadcastAs(): string
    {
        return 'challenge.stopped';
    }

    public function broadcastWith(): array
    {
        return [
            'event_id' => (int) $this->event->id,
            'challenge_id' => (int) $this->challenge->id,
        ];
    }
}
