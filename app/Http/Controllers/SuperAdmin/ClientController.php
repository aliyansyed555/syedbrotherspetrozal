<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // function create(){
    //     return view('super_admin.register-client');
    // }
    function index()
    {
        return view('super_admin.clients');
    }
    public function get_all_clients()
    {
        $users = User::role('client_admin')->select(['id', 'name', 'email', 'created_at'])->get();

        return response()->json([
            'recordsTotal' => $users->count(),
            'recordsFiltered' => $users->count(),
            'data' => $users
        ]);
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must be email address.'
        ]);

        // dd($validatedData);
        // Create the new user

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt('password123'),
        ]);

        // Assign 'client_admin' role
        $user->assignRole('client_admin');

        return response()->json(['success' => true, 'message' => 'Client created successfully.']);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id
        ], [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must be a valid email address.'
        ]);

        // Find the user by ID and update their details
        $user = User::findOrFail($id);
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        return response()->json(['success' => true, 'message' => 'Client updated successfully.']);
    }

    public function delete($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Delete the user
            $user->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Client deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            // Return error response if the user is not found
            return response()->json(['success' => false, 'message' => 'Client not found.'], 404);
        } catch (\Exception $e) {
            // Return error response for any other exceptions
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the client.'], 500);
        }
    }
}
