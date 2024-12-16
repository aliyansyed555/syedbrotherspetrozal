<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\TankStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TankStockController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user);
    }

    function index(Request $request)
    {

        $pump = $request->pump;
        $pump_id = $request->pump->id;
        $tanks = $pump->tanks()->get();
        // dd($tanks);
        return view('client_admin.pump.tank-stock', compact(['pump_id', 'tanks']));
    }

    function get_all(Request $request)
    {
        $pump = $request->pump;
        // Retrieve the pump based on pump_id and ensure it belongs to the user's company

        if (!$pump) {
            return response()->json([
                'redirect_url' => route('error.404'),
            ], 404);
        }

        $tanks = $pump->tanks;
        // $stocks = TankStock::whereIn('tank_id', $tanks->pluck('id'))->get();
        $stocks = TankStock::select('tank_stocks.*', 'tanks.name as tank_name')
            ->join('tanks', 'tank_stocks.tank_id', '=', 'tanks.id')
            ->whereIn('tank_id', $tanks->pluck('id'))
            ->get();

        // Return the pricing data as a JSON response
        return response()->json([
            'recordsTotal' => $stocks->count(),
            'recordsFiltered' => $stocks->count(),
            'success' => true,
            'data' => $stocks,
        ]);
    }

    public function create(Request $request)
    {
        $pump = $request->pump;
        $validatedData = $request->validate([
            'reading_in_ltr' => [
                'required',
                'numeric',
                'regex:/^\d{1,11}(\.\d{1,2})?$/',
            ],
            'tank_id' => [
                'required',
                'integer',
                Rule::exists('tanks', 'id')->where('petrol_pump_id', $pump->id),
            ],
            'date' => [
                'required',
                'date',
            ],
        ], [
            'reading_in_ltr.required' => 'The reading in liters field is required.',
            'reading_in_ltr.integer' => 'The reading in liters must be a valid integer.',
            'reading_in_ltr.regex' => 'The reading in ltr can have up to 11 digits before the decimal and 2 digits after.',
            'tank_id.required' => 'Tank cannot be empty',
            'tank_id.integer' => 'Tank value should be correct',
            'tank_id.exists' => 'Access denied to Tank',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date format.',
        ]);


        TankStock::create([
            'reading_in_ltr' => $validatedData['reading_in_ltr'],
            'tank_id' => $validatedData['tank_id'],
            'date' => $validatedData['date'],
        ]);

        return response()->json(['success' => true, 'message' => 'Stock Added successfully.']);
    }

    public function update(Request $request, $pump_id)
    {
        $pump = $request->pump;

        $validatedData = $request->validate([
            'id' => 'required|exists:tank_stocks,id',
            'reading_in_ltr' => [
                'required',
                'numeric',
                'regex:/^\d{1,11}(\.\d{1,2})?$/',
            ],
            'tank_id' => [
                'required',
                'integer',
                Rule::exists('tanks', 'id')->where('petrol_pump_id', $pump->id),
            ],
            'date' => [
                'required',
                'date',
            ],
        ], [
            'reading_in_ltr.required' => 'The reading in liters field is required.',
            'reading_in_ltr.integer' => 'The reading in liters must be a valid integer.',
            'reading_in_ltr.regex' => 'The reading in ltr can have up to 11 digits before the decimal and 2 digits after.',
            'tank_id.required' => 'Tank cannot be empty',
            'tank_id.integer' => 'Tank value should be correct',
            'tank_id.exists' => 'Access denied to Tank',
            'date.required' => 'The date field is required.',
            'date.date' => 'The date must be a valid date format.',
        ]);

        try {
            // $tank = $pump->fuelPrices()->find($request->id);
            $tankStock = TankStock::whereHas('tank', function ($query) use ($pump) {
                $query->where('petrol_pump_id', $pump->id); 
            })->find($request->id);

            // $tankStock = $pump->tanks()->find($request->id);
            if (!$tankStock) {
                return response()->json(['success' => false, 'message' => 'Access denied to Tank.'], 404);
            }

            // Update the record
            $tankStock->update([
                'reading_in_ltr' => $validatedData['reading_in_ltr'],
                'tank_id' => $validatedData['tank_id'],
                'date' => $validatedData['date'],
            ]);

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Stock updated successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the Stock.',
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
            $pricing = TankStock::findOrFail($id);
            $pricing->delete();
            return response()->json(['success' => true, 'message' => 'Fuel price deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Fuel price.'], 500);
        }
    }
}
