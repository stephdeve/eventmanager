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
        $asJson = $request->expectsJson() || $request->ajax();
        // Event must be finished
        if (!$event->end_date || now()->lt($event->end_date)) {
            if ($asJson) {
                return response()->json([
                    'success' => false,
                    'message' => "Vous pourrez laisser un avis après la fin de l'événement.",
                ], 422);
            }
            return back()->with('error', "Vous pourrez laisser un avis après la fin de l'événement.");
        }

        // Must have participated (has a registration)
        $hasRegistration = Registration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();
        if (!$hasRegistration) {
            if ($asJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seuls les participants peuvent laisser un avis.',
                ], 403);
            }
            return back()->with('error', "Seuls les participants peuvent laisser un avis.");
        }

        // Prevent duplicate review
        $already = EventReview::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->exists();
        if ($already) {
            if ($asJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous avez déjà laissé un avis pour cet événement.',
                ], 409);
            }
            return back()->with('info', 'Vous avez déjà laissé un avis pour cet événement.');
        }

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $review = EventReview::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'rating' => (int) $data['rating'],
            'comment' => $data['comment'],
            'approved' => true, // auto-approve for now
        ]);

        if ($asJson) {
            $avg = (float) ($event->reviews()->avg('rating') ?? 0);
            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre avis !',
                'avg_rating' => round($avg, 1),
                'review' => [
                    'user' => [ 'name' => optional(Auth::user())->name ],
                    'rating' => (int) $review->rating,
                    'comment' => (string) $review->comment,
                    'created_at' => now()->format('d/m/Y H:i'),
                ],
            ]);
        }

        return back()->with('success', 'Merci pour votre avis !');
    }
}
