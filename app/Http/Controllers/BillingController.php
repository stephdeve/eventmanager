<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a simple billing history for the organizer.
     */
    public function history()
    {
        $user = Auth::user();

        // Event-related payments for events organized by this user
        $eventPayments = Registration::with(['event', 'user'])
            ->whereHas('event', function ($q) use ($user) { $q->where('organizer_id', $user->id); })
            ->orderByDesc('created_at')
            ->take(50)
            ->get();

        return view('billing.history', [
            'user' => $user,
            'eventPayments' => $eventPayments,
        ]);
    }
}
