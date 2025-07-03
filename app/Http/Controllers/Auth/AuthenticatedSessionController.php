<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use App\Models\AuditTrail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

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


    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     // Validate the credentials (optional if LoginRequest already handles it)
    //     $request->validate([
    //         'email' => ['required', 'string', 'email'],
    //         'password' => ['required', 'string'],
    //     ]);

    //     // Attempt to authenticate
    //     if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
    //         return back()->withErrors([
    //             'email' => 'The provided credentials do not match our records.',
    //         ]);
    //     }


    //     // Regenerate session to prevent fixation
    //     $request->session()->regenerate();

    //     $user = Auth::user();

    //     // Redirect based on user type
    //     if ($user->status !== 'active') {
    //         Auth::logout();
    //         session()->flash('error', 'Your account is inactive. Please contact support.');
    //         return redirect()->back();
    //     }

    //     // Redirect based on user type
    //     if ($user->usertype === 'admin') {
    //         session()->flash('success', 'Welcome to administrator dashboard.');
    //         return redirect()->route('admin.dashboard');
    //     }

    //     if ($user->usertype === 'driver') {
    //         session()->flash('success', 'Welcome to tricycle dashboard.');
    //         return redirect()->route('driver.dashboard');
    //     }

    //     if ($user->usertype === 'passenger') {
    //         session()->flash('success', 'Welcome to passenger dashboard.');
    //         return redirect()->route('passenger.dashboard');
    //     }

    //     // Fallback for unknown user types
    //     Auth::logout();
    //     return redirect()->route('login')->withErrors(['user' => 'Unauthorized user role.']);
    // }


    public function store(LoginRequest $request): RedirectResponse
    {

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        if ($user->status !== 'active') {
            Auth::logout();
            session()->flash('error', 'Your account is inactive. Please contact support.');
            return redirect()->back();
        }

        // Log the login activity
        $this->logLoginActivity($user, $request);

        return $this->redirectUserBasedOnType($user);
    }

    /**
     * Redirect the user based on their user type.
     *
     * @param User $user
     * @return RedirectResponse
     */
    private function redirectUserBasedOnType($user): RedirectResponse
    {
        switch ($user->usertype) {
            case 'admin':
                session()->flash('success', 'Welcome to the administrator dashboard.');
                return redirect()->route('admin.dashboard');

            case 'driver':
                session()->flash('success', 'Welcome to the tricycle dashboard.');
                return redirect()->route('driver.dashboard');

            case 'passenger':
                session()->flash('success', 'Welcome to the passenger dashboard.');
                return redirect()->route('passenger.dashboard');

            default:
                Auth::logout();
                return redirect()->route('login')->withErrors(['user' => 'Unauthorized user role.']);
        }
    }

    /**
     * Log the login activity for the user.
     *
     * @param User $user
     * @return void
     */
    private function logLoginActivity($user): void
    {
        AuditTrail::create([
            'user_id' => $user->id,
            'activity' => 'User  logged in',
            'name' => $user->name,
            'usertype' => $user->usertype,
            'email' => $user->email,
            'date' => now(),
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Auth::guard('web')->logout();

        $user = Auth::user();

        if ($user) {
            AuditTrail::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'activity' => 'User logged out',
                'usertype' => $user->usertype,
                'date' => now(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
