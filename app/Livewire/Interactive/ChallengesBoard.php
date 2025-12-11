<?php

namespace App\Livewire\Interactive;

use App\Models\Challenge;
use App\Models\Event;
use App\Events\ChallengeStarted;
use App\Events\ChallengeStopped;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChallengesBoard extends Component
{
    public Event $event;
    public ?string $activeChallengeId = null;
    public ?string $activeEndsAt = null;
    public int $durationMinutes = 5;
    public array $leaderboard = [];

    public function mount(Event $event): void
    {
        $this->event = $event->loadMissing(['participants', 'challenges']);
        $this->refreshActiveFromCache();
        $this->computeLeaderboard();
    }

    public function render()
    {
        $this->refreshActiveFromCache();
        // Auto-expire across any render once the timer has elapsed
        if ($this->activeChallengeId && $this->activeEndsAt) {
            $ends = Carbon::parse($this->activeEndsAt);
            if (now()->greaterThanOrEqualTo($ends)) {
                $this->expireChallenge();
            }
        }
        $this->computeLeaderboard();
        return view('livewire.interactive.challenges-board');
    }

    protected function refreshActiveFromCache(): void
    {
        $key = $this->cacheKey();
        $payload = Cache::get($key);
        if (is_array($payload)) {
            $this->activeChallengeId = $payload['id'] ?? null;
            $this->activeEndsAt = $payload['ends_at'] ?? null;
        } elseif ($payload) {
            $this->activeChallengeId = $payload;
            $this->activeEndsAt = null;
        } else {
            $this->activeChallengeId = null;
            $this->activeEndsAt = null;
        }
    }

    protected function cacheKey(): string
    {
        return sprintf('interactive:event:%s:active_challenge', $this->event->id);
    }

    public function startChallenge(string $challengeId): void
    {
        // Only organizer/admin
        abort_unless(Auth::check() && Auth::user()->can('update', $this->event), 403);

        // Event must be interactive active
        if (!$this->event->isInteractiveActive()) {
            $this->dispatch('toast', type: 'warning', message: "L'événement interactif n'est pas actif.");
            return;
        }

        $challenge = Challenge::where('event_id', $this->event->id)->findOrFail($challengeId);
        $duration = max(1, (int) $this->durationMinutes) * 60;
        $endsAt = now()->addSeconds($duration);
        $payload = [
            'id' => $challenge->id,
            'started_at' => now()->toIso8601String(),
            'ends_at' => $endsAt->toIso8601String(),
            'duration' => $duration,
        ];
        Cache::put($this->cacheKey(), $payload, $endsAt);
        $this->activeChallengeId = $challenge->id;
        $this->activeEndsAt = $payload['ends_at'];
        $this->dispatch('toast', type: 'success', message: 'Défi démarré: ' . (string) $challenge->title);
        
        // Broadcasting en temps réel (optionnel)
        try {
            event(new ChallengeStarted($this->event, $challenge, $endsAt));
        } catch (\Throwable $e) {
            report($e);
        }
        $this->dispatch('$refresh');
    }

    public function stopChallenge(): void
    {
        abort_unless(Auth::check() && Auth::user()->can('update', $this->event), 403);
        Cache::forget($this->cacheKey());
        if ($this->activeChallengeId) {
            $challenge = $this->event->challenges->firstWhere('id', $this->activeChallengeId);
            if ($challenge) {
                // Broadcasting en temps réel (optionnel)
                try {
                    event(new ChallengeStopped($this->event, $challenge));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }
        $this->activeChallengeId = null;
        $this->activeEndsAt = null;
        $this->dispatch('toast', type: 'info', message: 'Défi terminé.');
        $this->dispatch('$refresh');
    }

    protected function expireChallenge(): void
    {
        $payload = Cache::get($this->cacheKey());
        if (!$payload) { $this->activeChallengeId = null; $this->activeEndsAt = null; return; }
        Cache::forget($this->cacheKey());
        if ($this->activeChallengeId) {
            $challenge = $this->event->challenges->firstWhere('id', $this->activeChallengeId);
            if ($challenge) {
                // Broadcasting en temps réel (optionnel)
                try {
                    event(new ChallengeStopped($this->event, $challenge));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }
        $this->activeChallengeId = null;
        $this->activeEndsAt = null;
        $this->dispatch('$refresh');
    }

    protected function computeLeaderboard(): void
    {
        $this->leaderboard = [];
        if (!$this->activeChallengeId) {
            return;
        }
        $rows = DB::table('votes')
            ->select('participant_id', DB::raw('SUM(value) as points'))
            ->where('event_id', $this->event->id)
            ->where('challenge_id', $this->activeChallengeId)
            ->groupBy('participant_id')
            ->orderByDesc('points')
            ->limit(10)
            ->get();

        if ($rows->isEmpty()) return;

        $maxPoints = (int) ($rows->max('points') ?? 0);
        $sumPoints = (int) $rows->sum('points');
        $map = $this->event->participants->whereIn('id', $rows->pluck('participant_id')->all())->keyBy('id');
        foreach ($rows as $r) {
            $p = $map->get($r->participant_id);
            if ($p) {
                $points = (int) $r->points;
                $percent = $maxPoints > 0 ? round(($points / $maxPoints) * 100) : 0;
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
}
