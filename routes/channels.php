<?php

use App\Models\Event;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('events.{event}', function ($user, Event $event) {
    return (int) $user->id === (int) $event->organizer_id;
});
