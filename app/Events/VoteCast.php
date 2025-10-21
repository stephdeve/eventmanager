<?php

namespace App\Events;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteCast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $afterCommit = true;

    public function __construct(
        public Event $event,
        public Participant $participant,
        public int $totalVotes
    ) {}

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('event.' . $this->event->id);
    }

    public function broadcastAs(): string
    {
        return 'vote.cast';
    }

    public function broadcastWith(): array
    {
        return [
            'participant_id' => (int) $this->participant->id,
            'total_votes' => (int) $this->totalVotes,
        ];
    }
}
