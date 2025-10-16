<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSubscription
{
    /**
     * Handle an incoming request.
     * Blocks organizer features if the user's subscription is expired or inactive.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return $next($request);
        }

        // Admins always pass
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        // Require active organizer subscription
        if (method_exists($user, 'hasActiveSubscription') && $user->hasActiveSubscription()) {
            return $next($request);
        }

        $message = 'Votre abonnement organisateur a expiré ou est inactif. Veuillez le renouveler pour continuer.';

        if ($request->expectsJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 402);
        }

        return redirect()->route('subscriptions.plans')->with('error', $message);
    }
}
