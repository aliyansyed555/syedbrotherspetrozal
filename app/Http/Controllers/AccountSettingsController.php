<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Models\User;

class AccountSettingsController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = $this->user->company;
    }

    public function getProfileCompletion()
    {
        $fields = [
            'name' => $this->user->name,
            'email_verified_at' => $this->user->email_verified_at,
            'address' => $this->user->address,
            'phone_number' => $this->user->phone_number,
            'image' => $this->user->image,  
            'company' => $this->user->company, 
        ];

        $completedFields = 0;

        foreach ($fields as $field => $value) {
            if ($value) {
                $completedFields++;
            }
        }

        // Calculate the percentage of completion
        $totalFields = count($fields);
        $completionPercentage = round(($completedFields / $totalFields) * 100, 2);

        return $completionPercentage;
    }

    private function getUserData()
    {
        $user = $this->user; // Get the currently authenticated user
        $role = $this->user->getRoleNames()->first();
        $company = $this->user->company;
        $completion = $this->getProfileCompletion();

        return compact('user', 'role', 'company', 'completion');
    }
    public function index()
    {
        $data = $this->getUserData(); // Get the shared user data
        return view('account.settings', $data);
    }

    public function update(Request $request)
    {
        $user = $this->user;
        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // dd($request->all());
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8',
        ]);

        // Update user fields
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->phone_number = $validatedData['phone_number'];

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->image = $imagePath;
        }

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Account updated successfully']);
    }

    public function resend_verification_email(Request $request)
    {

        // Generate a new verification token
        $token = Str::random(60);
        $this->user->verification_token = $token;
        $this->user->save();

        // Send the verification email
        Mail::to($this->user->email)->send(new EmailVerification($token));

        return response()->json(['message' => 'Verification email sent successfully.']);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid or expired token.'], 400);
        }

        // Mark the email as verified
        $user->email_verified_at = now();   
        $user->verification_token = null; 
        $userSaved = $user->save(); 

        if ($userSaved) {
            $status = true;
        } else {
            $status = false;
        }
        // Flash the status to session
        // session()->flash('status', $status);

        // Get user data and add status/message
        $data = $this->getUserData();
        return redirect()->route('account.settings')->with('status', $status);
    }
}
