<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\FuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FuelTypeController extends Controller
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
        return view('client_admin.fuelType');
    }


    public function get_all()
    {
        $fuel_type = $this->company->fuelTypes;

        return response()->json([
            'data' => $fuel_type,
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fuel_types', 'name')->where(function ($query) {
                    return $query->where('company_id', $this->company->id);
                })
            ],
        ], [
            'name.required' => 'Name is required.',
            'name.unique' => 'Fuel type already exists.',
        ]);

        FuelType::create([
            'name' => $validatedData['name'],
            'company_id' => $this->company->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Fuel type created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required.',
        ]);

        $fuel_type = FuelType::findOrFail($id);
        $updateData = [
            'name' => $validatedData['name'],
        ];

        $fuel_type->update($updateData);
        return response()->json(['success' => true, 'message' => 'Fuel type updated successfully.']);
    }

    public function delete($id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $fuel_type = FuelType::findOrFail($id);
            $fuel_type->delete();
            return response()->json(['success' => true, 'message' => 'Fuel type deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Fuel type.'], 500);
        }
    }
}
