<?php

namespace App\Http\Middleware;

use App\Models\PetrolPump;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyPumpOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $pump_id = $request->route('pump_id');
        $user = Auth::user();
        $company = get_company($user);
        
        $pump = PetrolPump::where('id', $pump_id)
            ->where('company_id', $company->id)
            ->first();

        if (!$pump) {
            return response()->json(['success' => false, 'message' => 'Pump not found or does not belong to your company.'], 404);
        }

        // Bind the pump to the request
        $request->merge(['pump' => $pump]);

        return $next($request);
    }
}
