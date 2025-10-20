<?php

namespace App\Http\Controllers;

use App\Events\EventMessageSent;
use App\Events\EventMessagePing;
use App\Models\ChatMessage;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Event $event)
    {
        $user = Auth::user();
        $allowed = $event->organizer_id === $user->id || Registration::where('event_id', $event->id)->where('user_id', $user->id)->exists();
        if (!$allowed) {
            return redirect()->route('events.show', $event)->with('error', "Accès refusé à la communauté de cet événement.");
        }

        $messages = ChatMessage::with('user')
            ->where('event_id', $event->id)
            ->orderByDesc('id')
            ->limit(50)
            ->get()
            ->reverse()
            ->values();

        $readOnly = $event->end_date && now()->gte($event->end_date);

        return view('events.chat', [
            'event' => $event,
            'messages' => $messages,
            'readOnly' => $readOnly,
        ]);
    }

    public function store(Request $request, Event $event)
    {
        $user = Auth::user();
        $allowed = $event->organizer_id === $user->id || Registration::where('event_id', $event->id)->where('user_id', $user->id)->exists();
        if (!$allowed) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        if ($event->end_date && now()->gte($event->end_date)) {
            return response()->json(['success' => false, 'message' => 'La communauté est clôturée.'], 403);
        }

        $data = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        $chat = ChatMessage::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'message' => $data['message'],
        ]);

        $chat->load('user');

        broadcast(new EventMessageSent($event, $chat))->toOthers();

        // Notify other participants (organizer + registrants except sender)
        $recipientIds = Registration::where('event_id', $event->id)
            ->where('user_id', '!=', $user->id)
            ->pluck('user_id')
            ->unique();
        if ($event->organizer_id && $event->organizer_id !== $user->id) {
            $recipientIds->push($event->organizer_id);
        }
        $recipientIds = $recipientIds->unique()->values();
        $snippet = mb_strimwidth($chat->message, 0, 80, '…', 'UTF-8');
        foreach ($recipientIds->chunk(100) as $chunk) {
            foreach ($chunk as $rid) {
                broadcast(new EventMessagePing((int) $rid, (int) $event->id, (string) $event->title, (string) ($user->name ?? 'Participant'), $snippet));
            }
        }

        return response()->json([
            'success' => true,
            'message' => [
                'id' => (int) $chat->id,
                'user' => [
                    'id' => (int) $user->id,
                    'name' => (string) ($user->name ?? 'Participant'),
                ],
                'message' => (string) $chat->message,
                'created_at' => $chat->created_at?->toIso8601String(),
            ],
        ]);
    }
}
