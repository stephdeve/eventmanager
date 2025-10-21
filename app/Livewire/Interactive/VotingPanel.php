<?php

namespace App\Livewire\Interactive;

use App\Events\VoteCast;
use App\Events\VoteNotification;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Setting;
use App\Models\Vote;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class VotingPanel extends Component
{
    public Event $event;
    public ?int $walletBalance = null;

    public function mount(Event $event): void
    {
        $this->event = $event->loadMissing(['participants']);
        if (Auth::check()) {
            $this->walletBalance = app(WalletService::class)->ensure(Auth::id())->balance;
        }
    }

    public function render()
    {
        return view('livewire.interactive.voting-panel');
    }

    protected function checkThrottle(): bool
    {
        $userId = Auth::id() ?: request()->ip();
        $key = sprintf('votes:%s:%d', $userId, $this->event->id);
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $this->dispatch('toast', type: 'warning', message: 'Trop de votes en peu de temps. Réessayez plus tard.');
            return false;
        }
        RateLimiter::hit($key, 60);
        return true;
    }

    public function freeVote(int $participantId): void
    {
        abort_unless(Auth::check(), 403);
        if (!$this->event->isInteractiveActive()) {
            $this->dispatch('toast', type: 'warning', message: 'Votes indisponibles pour le moment.');
            return;
        }
        if (!$this->checkThrottle()) return;
        $participant = Participant::where('event_id', $this->event->id)->findOrFail($participantId);

        // Limite: 1 vote gratuit par jour et par utilisateur pour cet événement
        $userId = Auth::id();
        $today = now()->startOfDay();
        $exists = Vote::where('user_id', $userId)
            ->where('event_id', $this->event->id)
            ->where('vote_type', 'free')
            ->where('created_at', '>=', $today)
            ->exists();
        if ($exists) {
            $this->dispatch('toast', type: 'warning', message: "Vous avez déjà utilisé votre vote gratuit aujourd'hui.");
            return;
        }

        DB::transaction(function () use ($participant, $userId) {
            $vote = Vote::create([
                'user_id' => $userId,
                'participant_id' => $participant->id,
                'event_id' => $this->event->id,
                'value' => 1,
                'vote_type' => 'free',
            ]);

            // Mettre à jour le score cache et diffuser l'événement
            $participant->increment('score_total', 1);
            $participant->refresh();
            event(new VoteCast($this->event, $participant, $participant->score_total));
            // Notifier l'organisateur
            if ($this->event->organizer_id) {
                event(new VoteNotification(
                    (int) $this->event->organizer_id,
                    (int) $this->event->id,
                    (string) $this->event->title,
                    (string) $participant->name,
                    (int) $participant->score_total,
                    route('interactive.events.show', ['event' => $this->event->slug ?? $this->event->id])
                ));
            }
        });

        $this->dispatch('toast', type: 'success', message: 'Vote gratuit enregistré.');
        $this->dispatch('$refresh');
    }

    public function premiumVote(int $participantId): void
    {
        abort_unless(Auth::check(), 403);
        if (!$this->event->isInteractiveActive()) {
            $this->dispatch('toast', type: 'warning', message: 'Votes indisponibles pour le moment.');
            return;
        }
        if (!$this->checkThrottle()) return;
        $participant = Participant::where('event_id', $this->event->id)->findOrFail($participantId);

        // Débit de coins (paramétrable)
        $cost = (int) (Setting::get('interactive.premium_vote_cost', 10) ?? 10);
        $wallet = app(WalletService::class);
        $ok = $wallet->debit(Auth::id(), max(1, $cost), ['reason' => 'premium_vote', 'event_id' => $this->event->id, 'participant_id' => $participant->id]);
        if (!$ok) {
            $this->dispatch('toast', type: 'warning', message: 'Solde insuffisant. Achetez des coins pour voter.');
            return;
        }

        DB::transaction(function () use ($participant) {
            Vote::create([
                'user_id' => Auth::id(),
                'participant_id' => $participant->id,
                'event_id' => $this->event->id,
                'value' => 1,
                'vote_type' => 'premium',
            ]);
            $participant->increment('score_total', 1);
            $participant->refresh();
            event(new VoteCast($this->event, $participant, $participant->score_total));
            if ($this->event->organizer_id) {
                event(new VoteNotification(
                    (int) $this->event->organizer_id,
                    (int) $this->event->id,
                    (string) $this->event->title,
                    (string) $participant->name,
                    (int) $participant->score_total,
                    route('interactive.events.show', ['event' => $this->event->slug ?? $this->event->id])
                ));
            }
        });

        $this->dispatch('toast', type: 'success', message: 'Vote premium pris en compte.');
        $this->walletBalance = app(WalletService::class)->ensure(Auth::id())->balance;
        $this->dispatch('$refresh');
    }
}
