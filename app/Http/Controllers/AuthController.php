<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function loginAction(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();
        

        if ($user) {
            // Attempt to log the user in
            $credentials = $request->only('email', 'password');

            if (Auth::guard('web')->attempt($credentials, $request->has('remember'))) {
                return redirect()->route('dashboard');
            }
        }

        // Authentication or location verification failed, redirect back with error message
        return redirect()->back()->with('error', 'Invalid credentials or location')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}