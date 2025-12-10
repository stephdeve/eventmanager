<?php

namespace App\Livewire\Interactive;

use App\Models\Challenge;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChallengeLeaderboard extends Component
{
    public Event $event;
    public int $challengeId;

    public array $leaderboard = [];
    public ?Challenge $challenge = null;

    public function mount(Event $event, int $challengeId): void
    {
        $this->event = $event->loadMissing(['participants']);
        $this->challengeId = (int) $challengeId;
        $this->challenge = Challenge::where('event_id', $this->event->id)->find($this->challengeId);
        $this->refreshData();
    }

    public function render()
    {
        return view('livewire.interactive.challenge-leaderboard');
    }

    public function refreshData(): void
    {
        $this->leaderboard = [];
        $rows = DB::table('votes')
            ->select('participant_id', DB::raw('SUM(value) as points'))
            ->where('event_id', $this->event->id)
            ->where('challenge_id', $this->challengeId)
            ->groupBy('participant_id')
            ->orderByDesc('points')
            ->limit(10)
            ->get();

        if ($rows->isEmpty()) return;

        $max = (int) ($rows->max('points') ?? 0);
        $map = $this->event->participants->whereIn('id', $rows->pluck('participant_id')->all())->keyBy('id');
        foreach ($rows as $r) {
            $p = $map->get($r->participant_id);
            if (!$p) continue;
            $points = (int) $r->points;
            $percent = $max > 0 ? round(($points / $max) * 100) : 0;
            $this->leaderboard[] = [
                'participant_id' => (int) $p->id,
                'name' => (string) $p->name,
                'photo_path' => $p->photo_path,
                'points' => $points,
                'percent' => $percent,
            ];
        }
    }
}
