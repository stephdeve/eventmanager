<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventMessagePing implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $afterCommit = true;

    public function __construct(
        public int $recipientUserId,
        public int $eventId,
        public string $eventTitle,
        public string $authorName,
        public string $snippet
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('private-user.' . $this->recipientUserId);
    }

    public function broadcastAs(): string
    {
        return 'message.notification';
    }

    public function broadcastWith(): array
    {
        return [
            'event_id' => $this->eventId,
            'event_title' => $this->eventTitle,
            'author_name' => $this->authorName,
            'snippet' => $this->snippet,
            'url' => route('events.chat', ['event' => $this->eventId]),
        ];
    }
}
