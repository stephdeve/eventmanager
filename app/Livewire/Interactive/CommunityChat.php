<?php

namespace App\Livewire\Interactive;

use App\Events\EventMessageSent;
use App\Models\ChatMessage;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class CommunityChat extends Component
{
    public Event $event;
    public string $messageText = '';
    public bool $readOnly = false;
    public int $onlineCount = 0;

    public function mount(Event $event): void
    {
        $this->event = $event;
        $user = Auth::user();
        $allowed = $user && ($event->organizer_id === $user->id || Registration::where('event_id', $event->id)->where('user_id', $user->id)->exists());
        abort_unless($allowed, 403);
        $this->readOnly = $event->end_date && now()->gte($event->end_date);
    }

    public function getListeners()
    {
        return [
            "echo-presence:event.{$this->event->id},.message.sent" => 'refreshMessages',
            "echo-presence:event.{$this->event->id},here" => 'updateOnlineUsers',
            "echo-presence:event.{$this->event->id},joining" => 'userJoined',
            "echo-presence:event.{$this->event->id},leaving" => 'userLeft',
        ];
    }

    public function updateOnlineUsers($users)
    {
        $this->onlineCount = count($users);
        $this->dispatch('update-online-count', count: count($users));
    }

    public function userJoined($user)
    {
        $this->onlineCount++;
        $this->dispatch('update-online-count', count: 'increment');
    }

    public function userLeft($user)
    {
        $this->onlineCount = max(0, $this->onlineCount - 1);
        $this->dispatch('update-online-count', count: 'decrement');
    }

    public function sendMessage(): void
    {
        \Illuminate\Support\Facades\Log::info('sendMessage called', ['text' => $this->messageText, 'readOnly' => $this->readOnly]);

        if ($this->readOnly) {
             \Illuminate\Support\Facades\Log::info('sendMessage aborted: readOnly');
             return;
        }
        $text = trim($this->messageText);
        if ($text === '') {
             \Illuminate\Support\Facades\Log::info('sendMessage aborted: empty text');
             return;
        }

        // Anti-spam basic throttle
        $key = 'chat:' . (Auth::id() ?: request()->ip());
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $this->dispatch('toast', type: 'warning', message: 'Trop de messages envoyés, réessayez plus tard.');
            return;
        }
        RateLimiter::hit($key, 60);

        // 1) Toujours enregistrer le message
        try {
            $chat = ChatMessage::create([
                'event_id' => $this->event->id,
                'user_id' => Auth::id(),
                'message' => mb_substr($text, 0, 1000),
            ]);
            $chat->load('user');
            \Illuminate\Support\Facades\Log::info('Message created', ['id' => $chat->id]);
        } catch (\Throwable $e) {
            report($e);
            \Illuminate\Support\Facades\Log::error('Message creation failed', ['error' => $e->getMessage()]);
            $this->dispatch('toast', type: 'error', message: "Impossible d'envoyer le message. Réessaie.");
            return;
        }

        // 2) Informer le front pour affichage immédiat (fallback si Echo HS)
        $this->dispatch('message-sent', message: [
            'id' => (int) $chat->id,
            'user' => [
                'id' => (int) (Auth::id() ?? 0),
                'name' => (string) (optional(Auth::user())->name ?? 'Participant'),
            ],
            'message' => (string) $chat->message,
            'created_at' => $chat->created_at?->toIso8601String(),
        ]);

        // 3) Diffuser en temps réel (avec tolérance en cas d'échec)
        try {
            broadcast(new EventMessageSent($this->event, $chat))->toOthers();
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch('toast', type: 'warning', message: 'Temps réel indisponible. Message envoyé.');
        }

        $this->messageText = '';
    }

    public function getMessagesProperty()
    {
        return ChatMessage::with('user')
            ->where('event_id', $this->event->id)
            ->orderByDesc('id')
            ->limit(50)
            ->get()
            ->reverse()
            ->values();
    }

    public function render()
    {
        return view('livewire.interactive.community-chat');
    }

    #[On('refresh-messages')]
    public function refreshMessages(): void
    {
        // no-op: forces rerender
    }
}
