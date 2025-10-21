<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $afterCommit = true;

    public function __construct(
        public int $recipientUserId,
        public int $eventId,
        public string $eventTitle,
        public string $participantName,
        public int $totalVotes,
        public ?string $url = null,
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('user.' . $this->recipientUserId);
    }

    public function broadcastAs(): string
    {
        return 'vote.notification';
    }

    public function broadcastWith(): array
    {
        return [
            'event_id' => $this->eventId,
            'event_title' => $this->eventTitle,
            'participant_name' => $this->participantName,
            'total_votes' => $this->totalVotes,
            'url' => $this->url,
        ];
    }
}
