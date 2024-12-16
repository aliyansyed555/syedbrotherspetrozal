<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckOwnerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has the 'admin-access' permission
        if ($user->can('owner-access')) {
            return $next($request); // Allow access
        }

        // Deny access for users without the permission
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this area.');
    }
}
