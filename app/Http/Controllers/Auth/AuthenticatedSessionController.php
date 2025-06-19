<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->usertype === 'admin') {
            return route('admin.faretable');
        }

        if ($user->usertype === 'passenger') {
            return route('passenger.dashboard');
        }

        return '/';
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     if (! $request->hasValidSignature()) {
    //         return redirect()->route('login')->withErrors(['signature' => 'Invalid login attempt.']);
    //     }
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('passenger.dashboard', absolute: false));
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate the credentials (optional if LoginRequest already handles it)
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }


        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on user type
        if ($user->usertype === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->usertype === 'passenger') {
            return redirect()->route('passenger.dashboard');
        }

        // Fallback for unknown user types
        Auth::logout();
        return redirect()->route('login')->withErrors(['user' => 'Unauthorized user role.']);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
