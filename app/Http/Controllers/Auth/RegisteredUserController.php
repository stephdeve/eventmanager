<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['required', Rule::in(['user', 'organizer'])],
        ], [
            'account_type.required' => 'Veuillez choisir le type de compte.',
            'account_type.in' => 'Type de compte invalide.',
        ]);

        $wantsOrganizer = $validated['account_type'] === 'organizer';
        $role = $wantsOrganizer ? 'organizer' : 'student';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'subscription_plan' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($wantsOrganizer) {
            return redirect()->route('subscriptions.plans');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
