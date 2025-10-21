<?php

namespace App\Livewire\Interactive;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class Leaderboard extends Component
{
    public Event $event;
    public array $top = [];

    public function mount(Event $event): void
    {
        $this->event = $event;
        $this->refreshData();
    }

    #[On('refresh-leaderboard')]
    public function refreshData(): void
    {
        $this->top = $this->event->participants()
            ->orderByDesc('score_total')
            ->limit(10)
            ->get(['id','name','country','score_total'])
            ->map(fn ($p) => [
                'id' => (int) $p->id,
                'name' => (string) $p->name,
                'country' => (string) ($p->country ?? ''),
                'score_total' => (int) $p->score_total,
            ])->toArray();
    }

    public function render()
    {
        return view('livewire.interactive.leaderboard');
    }
}
