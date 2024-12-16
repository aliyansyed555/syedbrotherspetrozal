<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\FuelPrice;
use App\Models\PetrolPump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
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
        return view('client_admin.pump.pricing', compact(['fuel_types', 'pump_id']));
    }

    function get_all($pump_id){

        // Retrieve the pump based on pump_id and ensure it belongs to the user's company
        $pump = PetrolPump::where('id', $pump_id)
            ->where('company_id', $this->company->id) 
            ->first();

        if (!$pump) {
            return response()->json([
                'redirect_url' => route('error.404'),
            ], 404);
        }

        // Retrieve all fuel prices related to this pump
        $fuel_prices = $pump->fuelPrices()
            ->join('fuel_types', 'fuel_prices.fuel_type_id', '=', 'fuel_types.id')
            ->select('fuel_prices.*', 'fuel_types.name as fuel_type_name')
            ->get();

        // Return the pricing data as a JSON response
        return response()->json([ 
            'recordsTotal' => $fuel_prices->count(),
            'recordsFiltered' => $fuel_prices->count(),
            'success' => true,
            'data' => $fuel_prices,
        ]);
    
    }

    public function create(Request $request, $pump_id)
    {
        $validatedData = $request->validate([
            'selling_price' => 'required|numeric|between:0,999999.99',  
            'fuel_type_id' => 'required|integer|exists:fuel_types,id,company_id,' . $this->company->id, // Ensure fuel_type belongs to user's company
            'date' => 'required|date',  // Ensure the date is in a valid date format
        ], [
            'selling_price.required' => 'The selling price is required.',
            'selling_price.numeric' => 'The selling price must be a valid number.',
            'selling_price.between' => 'The selling price must be between 0 and 999,999.99.',
            'fuel_type_id.required' => 'The Fuel type is required.',
            'fuel_type_id.integer' => 'The Fuel type must be a valid integer.',
            'fuel_type_id.exists' => 'The selected fuel type is invalid or does not belong to your company.',
            'date.required' => 'The date is required.',
            'date.date' => 'The date must be a valid date format.',
        ]);

        FuelPrice::create([
            'selling_price' => $validatedData['selling_price'],
            'fuel_type_id' => $validatedData['fuel_type_id'],
            'petrol_pump_id' => $pump_id,
            'date' => $validatedData['date'],
        ]);

        return response()->json(['success' => true, 'message' => 'Fuel type created successfully.']);
        // return redirect()->route('client_admin.fueltype')->with('fuel_types', $fuel_types);
    }
    public function update(Request $request, $pricing_id)
    {
        $pump = $request->pump; 

        $validated = $request->validate([
            'id' => 'required|exists:fuel_prices,id',
            'selling_price' => 'required|numeric|between:0,999999.99',  
            'fuel_type_id' => 'required|integer|exists:fuel_types,id,company_id,' . $this->company->id, 
            'date' => 'required|date',  
        ], [
            'selling_price.required' => 'The selling price is required.',
            'selling_price.numeric' => 'The selling price must be a valid number.',
            'selling_price.between' => 'The selling price must be between 0 and 999,999.99.',
            'fuel_type_id.required' => 'The Fuel type is required.',
            'fuel_type_id.integer' => 'The Fuel type must be a valid integer.',
            'fuel_type_id.exists' => 'The selected fuel type is invalid or does not belong to your company.',
            'date.required' => 'The date is required.',
            'date.date' => 'The date must be a valid date format.',
        ]);

        try {
            // Find the pricing record by ID
            $pricing = $pump->fuelPrices()->find($request->id);
            if (!$pricing) {
                return response()->json(['success' => false, 'message' => 'Access denied to Pricing record.'], 404);
            }
            // Update the record
            $pricing->update([
                'date' => $validated['date'],
                'selling_price' => $validated['selling_price'],
                'fuel_type_id' => $validated['fuel_type_id'],
            ]);
    
            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Pricing updated successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the pricing.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($pump_id, $pricing_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $pricing = FuelPrice::findOrFail($pricing_id);
            $pricing->delete();
            return response()->json(['success' => true, 'message' => 'Fuel price deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Fuel price.'], 500);
        }
        
    }

    
}
