<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventReview;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Event $event)
    {
        // Event must be finished
        if (!$event->end_date || now()->lt($event->end_date)) {
            return back()->with('error', "Vous pourrez laisser un avis après la fin de l'événement.");
        }

        // Must have participated (has a registration)
        $hasRegistration = Registration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();
        if (!$hasRegistration) {
            return back()->with('error', "Seuls les participants peuvent laisser un avis.");
        }

        // Prevent duplicate review
        $already = EventReview::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();
        if ($already) {
            return back()->with('info', 'Vous avez déjà laissé un avis pour cet événement.');
        }

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        EventReview::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => (int) $data['rating'],
            'comment' => $data['comment'],
            'approved' => true, // auto-approve for now
        ]);

        return back()->with('success', 'Merci pour votre avis !');
    }
}
