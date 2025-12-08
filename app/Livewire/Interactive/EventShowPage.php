<?php

namespace App\Livewire\Interactive;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class EventShowPage extends Component
{
    public Event $event;
    public array $stats = [];
    public bool $isStreaming = false;
    public string $shareUrl = '';
    public ?string $replayUrl = null;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function render()
    {
        $votesCount = (int) $this->event->votes()->count();
        $participantsCount = (int) $this->event->participants()->count();
        $chatRecentDistinct = (int) $this->event->chatMessages()
            ->where('created_at', '>=', now()->subMinutes(15))
            ->distinct('user_id')
            ->count('user_id');
        $attendeesCount = (int) $this->event->attendees()->count();

        $this->stats = [
            'viewers' => $chatRecentDistinct > 0 ? $chatRecentDistinct : $attendeesCount,
            'votes' => $votesCount,
            'participants' => $participantsCount,
            'interactions' => $votesCount + (int) $this->event->chatMessages()->count(),
        ];

        $this->isStreaming = (bool) ($this->event->isInteractiveActive() && ($this->event->youtube_url || $this->event->tiktok_url));
        $this->shareUrl = route('interactive.events.show', ['event' => $this->event->slug ?? $this->event->id]);
        $this->replayUrl = $this->event->youtube_url ?: ($this->event->tiktok_url ?: null);

        return view('livewire.interactive.event-show-page');
    }
}
