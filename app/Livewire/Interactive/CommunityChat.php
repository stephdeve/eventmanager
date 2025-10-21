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

    public function mount(Event $event): void
    {
        $this->event = $event;
        $user = Auth::user();
        $allowed = $user && ($event->organizer_id === $user->id || Registration::where('event_id', $event->id)->where('user_id', $user->id)->exists());
        abort_unless($allowed, 403);
        $this->readOnly = $event->end_date && now()->gte($event->end_date);
    }

    public function send(): void
    {
        if ($this->readOnly) return;
        $text = trim($this->messageText);
        if ($text === '') return;

        // Anti-spam basic throttle
        $key = 'chat:' . (Auth::id() ?: request()->ip());
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $this->dispatch('toast', type: 'warning', message: 'Trop de messages envoyés, réessayez plus tard.');
            return;
        }
        RateLimiter::hit($key, 60);

        $chat = ChatMessage::create([
            'event_id' => $this->event->id,
            'user_id' => Auth::id(),
            'message' => mb_substr($text, 0, 1000),
        ]);
        $chat->load('user');

        event(new EventMessageSent($this->event, $chat));

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
