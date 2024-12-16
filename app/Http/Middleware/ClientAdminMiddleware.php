<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Example: Check if the authenticated user has the 'client_admin' role
        if (Auth::user() && (Auth::user()->hasRole('client_admin') || Auth::user()->hasRole('manager'))) {
            return $next($request);
        }

        // If the user is not a 'client_admin', redirect them or return an error
        return redirect()->route('dashboard'); // Redirect to home or some other page
    }
}
