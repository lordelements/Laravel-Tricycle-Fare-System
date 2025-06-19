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
//     public function store(Request $request): RedirectResponse
//     {
//         $request->validate([
//             'name' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//             'password' => ['required', 'confirmed', Rules\Password::defaults()],
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//         ]);

//         event(new Registered($user));

//         Auth::login($user);

//         return redirect(route('dashboard/passenger', absolute: false));
//     }
// }

public function store(Request $request): RedirectResponse
{
    // Validate the incoming registration data
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => strtolower($request->email), // normalize email
        'password' => Hash::make($request->password),
        'usertype' => 'passenger', // Set user type to passenger
    ]);

    // Fire the registered event (used for email verification, etc.)
    event(new Registered($user));

    // Log the user in
    Auth::login($user);

    // Redirect to passenger dashboard or user-type specific page
    return redirect()->route('passenger.dashboard');
}

}