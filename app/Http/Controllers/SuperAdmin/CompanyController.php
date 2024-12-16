<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function index()
    {
        return view('super_admin.company');
    }
    public function get_all_companies()
    {
        // $companies = User::role('client_admin')->select(['id', 'name', 'email', 'created_at'])->get();
        
        $companies = Company::get();
 
        return response()->json([
            'recordsTotal' => $companies->count(),
            'recordsFiltered' => $companies->count(),
            'success' => true,
            'data' => $companies,
        ]);
    }

    public function get_available_admins()
    {
        $availableAdmins = User::role('client_admin')->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'availableAdmins' => $availableAdmins,
        ]);
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',  // Ensure user_id is valid and exists in the users table
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Company name is required.',
            'user_id.required' => 'Admin user ID is required.',
            'user_id.exists' => 'The provided user ID does not exist.',
            'address.string' => 'Address should be a valid string.',
            'address.max' => 'Address can be up to 255 characters.',
        ]);
        // Check if the user already has a company
        $existingCompany = Company::where('user_id', $validatedData['user_id'])->first();

        if ($existingCompany) {
            return response()->json(['success' => false, 'message' => 'This client admin already has a company.'], 400);
        }

        // Create the company and associate it with the user (admin)
        Company::create([
            'name' => $validatedData['name'],
            'user_id' => $validatedData['user_id'],  // Associate the client admin user
            'address' => $validatedData['address'] ?? null,  // Handle nullable address
        ]);

        return response()->json(['success' => true, 'message' => 'Company created successfully.']);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',  // Ensure user_id is valid and exists in the users table
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Company name is required.',
            'user_id.required' => 'Admin user ID is required.',
            'user_id.exists' => 'The provided user ID does not exist.',
            'address.string' => 'Address should be a valid string.',
            'address.max' => 'Address can be up to 255 characters.',
        ]);

        // Find the user by ID and update their details
        $company = Company::findOrFail($id);
        $company->update([
            'name' => $validatedData['name'],
            'user_id' => $validatedData['user_id'], 
            'address' => $validatedData['address']?? null
        ]);

        return response()->json(['success' => true, 'message' => 'Company updated successfully.']);
    }

    public function delete($id)
    {
        try {
            // Find the user by ID
            $company = Company::findOrFail($id);

            // Delete the user
            $company->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Company deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            // Return error response if the user is not found
            return response()->json(['success' => false, 'message' => 'Company not found.'], 404);
        } catch (\Exception $e) {
            // Return error response for any other exceptions
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Company.'], 500);
        }
    }
}
