<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\TankStock;
use App\Models\FuelPurchase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
class FuelPurchaseController extends Controller
{
    private $user;
    private $company;
    private $pump;

    public function __construct(Request $request)
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user);

        $this->pump = $request->pump;
    }

    function index(Request $request)
    {
        $fuel_types = get_fuel_types_with_tanks($this->pump);

        #dd($fuel_types);
        $pump_id = $this->pump->id;
        return view('client_admin.pump.purchase', compact(['pump_id', 'fuel_types']));
    }

    public function get_all(Request $request)
    {
        $pump = $request->pump;

        $fuelPurchases = $pump->fuelPurchases()
            ->join('fuel_types', 'fuel_types.id', '=', 'fuel_purchases.fuel_type_id')
            ->select('fuel_purchases.*', 'fuel_types.name as fuel_type_name')
            ->get();


        // Return the pricing data as a JSON response
        return response()->json([
            'recordsTotal' => $fuelPurchases->count(),
            'recordsFiltered' => $fuelPurchases->count(),
            'success' => true,
            'data' => $fuelPurchases,
        ]);
    }

    public function getTanksByFuelType(Request $request)
    {
        $fuel_type_id = $request->fuel_type_id;

        $tanks = $this->pump->tanks()->whereHas('fuelType', function ($q) use ($fuel_type_id) {
            $q->where('id', $fuel_type_id);
        })->get();

        return response()->json(['success' => true, 'tanks' => $tanks]);
    }


    public function create(Request $request)
    {
        // dd($request->all());
        // Fetch the fuel types related to the current pump
        $fuel_types = get_fuel_types_with_tanks($this->pump);

        $validatedData = $request->validate([
            'fuel_quantity' => 'required|numeric',
            'fuel_type_id' => [
                'required',
                'integer',
            ],
            'purchase_date' => 'required|date',
            'buying_price_per_ltr' => 'required|numeric|min:1',
            'tank_stocks' => 'required|json',
        ], [
            'purchase_date.required' => 'Purchase date is required.',
            'fuel_quantity.required' => 'Fuel quantity is required.',
            'fuel_quantity.numeric' => 'Fuel quantity must be a valid number.',
            'fuel_quantity.min' => 'Fuel quantity must be greater than zero.',
            'fuel_type_id.required' => 'Fuel type is required.',
            'fuel_type_id.integer' => 'Fuel type must be an integer.',
            'buying_price_per_ltr.required' => 'Buying price per liter is required.',
            'buying_price_per_ltr.numeric' => 'Buying price per liter must be a valid number.',
            'buying_price_per_ltr.min' => 'Buying price per liter must be greater than zero.',
            'tank_stocks.required' => 'Tank stocks are required.',
            'tank_stocks.json' => 'Tank stocks must be a valid JSON array.',
        ]);

        // Validate fuel type
        if (!collect($fuel_types)->pluck('id')->contains($validatedData['fuel_type_id'])) {
            return response()->json(['error' => 'Invalid fuel type.'], 422);
        }

        // Decode the tank stocks
        $decodedTankStocks = json_decode($request->input('tank_stocks'), true);

        // Ensure decoded tank stocks is a valid array and contains required fields
        if (!is_array($decodedTankStocks) || empty($decodedTankStocks)) {
            return response()->json(['error' => 'Tank stocks must be a valid non-empty array.'], 422);
        }

        $totalTankQuantity = 0;
        foreach ($decodedTankStocks as $tankStock) {
            // Ensure each tank stock has the required fields
            if (!isset($tankStock['tank_id'], $tankStock['quantity']) || !is_numeric($tankStock['quantity'])) {
                return response()->json(['error' => 'Each tank stock must have a valid tank_id and quantity.'], 422);
            }

            $totalTankQuantity += (float) $tankStock['quantity'];
        }

        // Check if total tank quantities match the fuel quantity
        if ($totalTankQuantity !== (float) $validatedData['fuel_quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'The total quantity of stocks must equal the fuel quantity.',
            ], 422);
        }

        // Perform the database transaction
        DB::transaction(function () use ($validatedData, $decodedTankStocks) {
            // Create the fuel purchase
            $fuelPurchase = FuelPurchase::create([
                'petrol_pump_id' => $this->pump->id,
                'fuel_type_id' => $validatedData['fuel_type_id'],
                'quantity_ltr' => $validatedData['fuel_quantity'],
                'buying_price_per_ltr' => $validatedData['buying_price_per_ltr'],
                'purchase_date' => $validatedData['purchase_date'],
            ]);

            // Create tank stocks
            foreach ($decodedTankStocks as $tankStock) {
                TankStock::create([
                    'tank_id' => $tankStock['tank_id'],
                    'reading_in_ltr' => $tankStock['quantity'],
                    'date' => $validatedData['purchase_date'],
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Fuel and tank data saved successfully.',
        ]);
    }

    public function delete($pump_id, $purchase_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $purchase = FuelPurchase::findOrFail($purchase_id);
            if (!$this->company->petrolPumps->contains('id', $purchase->petrol_pump_id)) {
                return response()->json(['success' => false, 'message' => 'Access denied to Nozzle.'], 403);
            }
            $purchase->delete();
            return response()->json(['success' => true, 'message' => 'Purchase deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Purchase.'], 500);
        }
    }


}
