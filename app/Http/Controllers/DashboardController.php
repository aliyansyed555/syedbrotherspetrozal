<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $companyName = 'No Company Assigned';

        if ($user->hasRole('manager')) {
            if ($user->teamMembers->isNotEmpty()) {
                $companyName = $user->teamMembers->first()->company->name;
            }
        } else {
            if ($user->company) {
                $companyName = $user->company->name;
            }
        }

        return view('dashboard', [
            'companyName' => $companyName,
        ]);
    }
}
