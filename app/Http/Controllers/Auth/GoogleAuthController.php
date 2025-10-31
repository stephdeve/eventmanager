<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        session()->put('url.intended', url()->previous());
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Connexion via Google annulée.');
        }

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            Log::warning('Google OAuth error', ['message' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Impossible de se connecter avec Google. Veuillez réessayer.');
        }

        $email = (string) $googleUser->getEmail();
        $googleId = (string) $googleUser->getId();
        $name = (string) ($googleUser->getName() ?: ($googleUser->user['given_name'] ?? 'Utilisateur'));
        $avatar = (string) ($googleUser->getAvatar() ?? '');

        // Sécurité: si Google ne fournit pas d'email, on arrête ici
        if ($email === '') {
            return redirect()->route('login')->with('error', "Votre compte Google n'a pas fourni d'email. Activez l'autorisation d'email et réessayez.");
        }

        $user = User::where('google_id', $googleId)->first();
        if (!$user && $email !== '') {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $updates = [];
            if (empty($user->google_id)) { $updates['google_id'] = $googleId; }
            if (!empty($avatar) && $user->avatar_url !== $avatar) { $updates['avatar_url'] = $avatar; }
            if (empty($user->email_verified_at)) { $updates['email_verified_at'] = now(); }
            if (!empty($updates)) {
                $user->fill($updates)->save();
            }
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Str::random(40),
                'role' => 'student',
                'google_id' => $googleId,
                'avatar_url' => $avatar ?: null,
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        session()->flash('toast', 'Connexion réussie via Google ✅');

        $intended = session()->pull('url.intended');
        $target = $intended ?: (route('dashboard') ?? route('home'));
        return redirect()->intended($target);
    }
}
