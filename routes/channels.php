<?php

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('events.{event}', function ($user, Event $event) {
    return (int) $user->id === (int) $event->organizer_id;
});

Broadcast::channel('event.{eventId}', function ($user, $eventId) {
    $event = Event::find($eventId);
    if (!$event) return false;
    $allowed = (int) $user->id === (int) $event->organizer_id
        || Registration::where('event_id', $event->id)->where('user_id', $user->id)->exists();
    if (!$allowed) return false;
    return [
        'id' => (int) $user->id,
        'name' => (string) ($user->name ?? 'Participant'),
    ];
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
