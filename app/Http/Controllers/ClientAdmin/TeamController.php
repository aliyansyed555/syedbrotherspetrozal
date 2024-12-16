<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user); 
    }

    function index()
    {
        return view('client_admin.team');
    }

    public function get_all_members()
    {
        // $team_member = TeamMember::with(['user', 'company'])->get();
        $team_member = TeamMember::with(['user', 'company'])->where('company_id', $this->company->id)->get();

        // dd($team_member->toArray());
        $data = $team_member->map(function ($teamMember) {

            return [
                'id' => $teamMember->user->id,
                'name' => $teamMember->user->name,
                'email' => $teamMember->user->email,
            ];
        });
        return response()->json([
            'recordsTotal' => $team_member->count(),
            'recordsFiltered' => $team_member->count(),
            'success' => true,
            'data' => $data,
        ]);
    }


    public function create(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must be a valid email address.',
            'email.unique' => 'The email has already been taken.', 
        ]);

        $team_member = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt('petrozal123'),
        ]);
        $team_member->assignRole('manager');
        $id = $team_member->id;

        if ($id) {
            TeamMember::create([
                'user_id' => $id,
                'company_id' => $this->company->id,
            ]);
        }


        return response()->json(['success' => true, 'message' => 'Team Member created successfully.']);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:team_members,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Find the user by ID and update their details
        $team_member = TeamMember::findOrFail($id);

        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ];
        
        if (!empty($validatedData['password'])) {
            $updateData['password'] = bcrypt($validatedData['password']);
        }
        
        $team_member->update($updateData);

        return response()->json(['success' => true, 'message' => 'Team Member updated successfully.']);
    }

    public function delete($id)
    {
        try {
            // Find the user by ID
            $team_member = User::findOrFail($id);

            // Delete the user
            $team_member->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Team Member deleted successfully.']);
        } catch (\Exception $e) {
            // Return error response for any other exceptions
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Team Member.'], 500);
        }
    }

    public function multi_delete(Request $request)
{
    try {
        $ids = $request->input('ids');  // Get the array of IDs
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No team members selected.'], 400);
        }

        // Delete team members by IDs
        User::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Team Members deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Team Members.'], 500);
    }
}
}
