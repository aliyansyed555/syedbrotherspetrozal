<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\PetrolPump;
use App\Models\Tank;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TankController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user);
    }

    function index($pump_id)
    {
        $fuel_types = get_fuel_types($this->company);
        return view('client_admin.pump.tank', compact(['fuel_types', 'pump_id']));
    }

    function get_all(Request $request)
    {

        $tanks = $request->pump->tanks()
            ->withSum('tankStocks as total_stock', 'reading_in_ltr')
            ->get();

        $tanks = $tanks->map(function ($tank) {
            $fuelType = DB::table('fuel_types')->find($tank->fuel_type_id);
            $tank->fuel_type_name = $fuelType ? $fuelType->name : null;
            return $tank;
        });

        return response()->json([
            'recordsTotal' => $tanks->count(),
            'recordsFiltered' => $tanks->count(),
            'success' => true,
            'data' => $tanks,
        ]);
    }

    public function create(Request $request, $pump_id)
    {

        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tanks', 'name')->where(function ($query) use ($pump_id) {
                    return $query->where('petrol_pump_id', $pump_id);
                })
            ],
            'fuel_type_id' => [
                'required',
                'integer',
                Rule::exists('fuel_types', 'id')->where(function ($query) {
                    return $query->where('company_id', $this->company->id);
                })
            ]
        ], [
            'name.required' => 'Name is required.',
            'fuel_type_id.required' => 'The Fuel type is required.',
            'fuel_type_id.integer' => 'The Fuel type must be a valid integer.',
            'fuel_type_id.exists' => 'The selected fuel type is invalid or does not belong to your company.',
        ]);

        Tank::create([
            'name' => $validatedData['name'],
            'petrol_pump_id' => $pump_id,
            'fuel_type_id' => $validatedData['fuel_type_id'],
        ]);

        return response()->json(['success' => true, 'message' => 'Tank created successfully.']);
    }
    public function update(Request $request, $pump_id)
    {
        $pump = $request->pump;
        $validated = $request->validate([
            'id' => 'required|exists:tanks,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tanks', 'name')->where(function ($query) use ($pump_id) {
                    return $query->where('petrol_pump_id', $pump_id);
                })->ignore($request->id), // Ignore the current tank ID while checking for uniqueness
            ],
            'fuel_type_id' => [
                'required',
                'integer',
                Rule::exists('fuel_types', 'id')->where(function ($query) {
                    return $query->where('company_id', $this->company->id);
                })
            ]
        ], [
            'name.required' => 'Name is required.',
            'fuel_type_id.required' => 'The Fuel type is required.',
            'fuel_type_id.integer' => 'The Fuel type must be a valid integer.',
            'fuel_type_id.exists' => 'The selected fuel type is invalid or does not belong to your company.',
        ]);

        try {
            $tank = $pump->tanks()->find($request->id);
            if (!$tank) {
                return response()->json(['success' => false, 'message' => 'Access denied to Tank.'], 404);
            }
            // Find the tank record by ID
            // $tank = Tank::findOrFail($validated['id']);

            // Update the record
            $tank->update([
                'name' => $validated['name'], // Ensure name is updated correctly
                'fuel_type_id' => $validated['fuel_type_id'],
            ]);

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Tank updated successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the Tank.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($pump_id, $id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $pricing = Tank::findOrFail($id);
            $pricing->delete();
            return response()->json(['success' => true, 'message' => 'Fuel price deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Fuel price.'], 500);
        }
    }
}
