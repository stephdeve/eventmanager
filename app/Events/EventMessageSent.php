<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $afterCommit = true;

    public function __construct(public Event $event, public ChatMessage $message)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PresenceChannel('presence-event.' . $this->event->id);
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        $user = $this->message->user;
        return [
            'id' => (int) $this->message->id,
            'user' => [
                'id' => (int) optional($user)->id,
                'name' => (string) (optional($user)->name ?? 'Participant'),
            ],
            'message' => (string) $this->message->message,
            'created_at' => $this->message->created_at?->toIso8601String(),
        ];
    }
}
