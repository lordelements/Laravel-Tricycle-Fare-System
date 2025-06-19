<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->usertype !== $role) {
            // Redirect based on actual role
            switch (Auth::user()->usertype) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'driver':
                    return redirect()->route('tricycle.dashboard');
                case 'passenger':
                    return redirect()->route('passenger.dashboard');
                default:
                    abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
