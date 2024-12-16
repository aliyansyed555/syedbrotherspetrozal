<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            // Redirect to login if user is not authenticated
            return redirect()->route('login');
        }

        if(auth()->user()->hasRole('super_admin'))
        {
            return $next($request);
        }
        
        return redirect()->back();

    }

}
