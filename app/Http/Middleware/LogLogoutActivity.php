<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogLogoutActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            AuditTrail::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'activity' => 'User logged out',
                'usertype' => $user->usertype,
                'date' => now(),
            ]);
        }
        
        return $next($request);
    }
}
