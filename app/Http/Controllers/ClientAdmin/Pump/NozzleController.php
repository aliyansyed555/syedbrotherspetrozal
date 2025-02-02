<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\NozzleReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Nozzle;
use App\Models\PetrolPump;
use App\Models\FuelType;

class NozzleController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user);
    }

    /**
     * Retrieves all nozzles for the specified pump.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request)
    {
        $pump = $request->pump;

        $nozzles = $pump->nozzles()
            ->join('tanks', 'tanks.id', '=', 'nozzles.tank_id')
            ->join('fuel_types', 'fuel_types.id', '=', 'nozzles.fuel_type_id')
            ->select('nozzles.*', 'tanks.name as tank_name', 'fuel_types.name as fuel_type_name')
            ->get();

        // Return the pricing data as a JSON response
        return response()->json([
            'recordsTotal' => $nozzles->count(),
            'recordsFiltered' => $nozzles->count(),
            'success' => true,
            'data' => $nozzles,
        ]);
    }

    /**
     * Displays the view for creating a nozzle, passing along the fuel types, pump id and tanks.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index(Request $request)
    {
        $pump = $request->pump;
        $pump_id = $request->pump->id;
        $tanks = $pump->tanks()->get();

        $fuel_types = get_fuel_types($this->company);
        return view('client_admin.pump.nozzle', compact(['fuel_types', 'pump_id', 'tanks']));
    }

    /**
     * Creates a new nozzle.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {

        $pump = $request->pump;
        $validatedData = $request->validate([
            'analog_reading' => ['required', 'numeric'],
            'digital_reading' => ['required', 'numeric'],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'tank_id' => [
                'required',
                'integer',
                Rule::exists('tanks', 'id')->where('petrol_pump_id', $pump->id),
            ],
            'fuel_type_id' => [
                'required',
                'integer',
                Rule::exists('fuel_types', 'id')->where('company_id', $this->company->id),
            ],
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name can have up to 255 characters.',
            'tank_id.required' => 'Tank cannot be empty',
            'tank_id.integer' => 'Tank value should be correct',
            'tank_id.exists' => 'Access denied to Tank',
            'fuel_type_id.required' => 'Fuel type cannot be empty',
            'fuel_type_id.integer' => 'Fuel type value should be correct',
            'fuel_type_id.exists' => 'Access denied to Fuel type',
        ]);

        $nozzle = Nozzle::create([
            'name' => $validatedData['name'],
            'petrol_pump_id' => $pump->id,
            'tank_id' => $validatedData['tank_id'],
            'fuel_type_id' => $validatedData['fuel_type_id'],
        ]);

        if ($request->analog_reading || $request->digital_reading)
            DB::table('nozzle_readings')->insert([
                'nozzle_id' => $nozzle->id,
                'analog_reading' => round2Digit($request->analog_reading),
                'digital_reading' => round2Digit($request->digital_reading),
                'date' => $request->nozzles_date ?? now()->toDateString(),
            ]);

        return response()->json(['success' => true, 'message' => 'Nozzle created successfully.']);
    }

    public function update(Request $request)
    {

        $pump = $request->pump;

        $nozzle = Nozzle::findOrFail($request->id);
        if (!$nozzle) {
            return response()->json([
                'success' => false,
                'message' => 'Nozzle not found.',
            ], 404);
        }
        if ($nozzle->petrol_pump_id != $pump->id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied to Nozzle.',
            ], 403);
        }

        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'tank_id' => [
                'required',
                'integer',
                Rule::exists('tanks', 'id')->where('petrol_pump_id', $pump->id),
            ],
            'fuel_type_id' => [
                'required',
                'integer',
                Rule::exists('fuel_types', 'id')->where('company_id', $this->company->id),
            ],
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'name.max' => 'Name can have up to 255 characters.',
            'tank_id.required' => 'Tank cannot be empty',
            'tank_id.integer' => 'Tank value should be correct',
            'tank_id.exists' => 'Access denied to Tank',
            'fuel_type_id.required' => 'Fuel type cannot be empty',
            'fuel_type_id.integer' => 'Fuel type value should be correct',
            'fuel_type_id.exists' => 'Access denied to Fuel type',
        ]);

        $nozzle->name = $validatedData['name'];
        $nozzle->tank_id = $validatedData['tank_id'];
        $nozzle->fuel_type_id = $validatedData['fuel_type_id'];
        $nozzle->save();

        if ($request->analog_reading || $request->digital_reading) {
            $existingRecord = DB::table('nozzle_readings')
                ->where('nozzle_id', $nozzle->id)
                ->where('date', $request->nozzles_date ?? now()->toDateString())
                ->first();

            $data = [
                'nozzle_id' => $nozzle->id,
                'analog_reading' => $request->analog_reading ? round2Digit($request->analog_reading) : 0,
                'digital_reading' => $request->digital_reading ? round2Digit($request->digital_reading) : 0,
                'date' => $request->nozzles_date ?? now()->toDateString(),
            ];

            if ($existingRecord) {
                // Update existing record
                NozzleReading::where('id', $existingRecord->id)->update($data);
            } else {
                // Insert new record
                NozzleReading::create($data);
            }

        }

        return response()->json(['success' => true, 'message' => 'Nozzle updated successfully.']);
    }

    public function getTanksByFuelType(Request $request)
    {
        $pump = $request->pump;
        $fuel_type_id = $request->fuel_type_id;

        $tanks = $pump->tanks()->whereHas('fuelType', function ($q) use ($fuel_type_id) {
            $q->where('id', $fuel_type_id);
        })->get();

        return response()->json(['success' => true, 'tanks' => $tanks]);
    }

    public function delete($pump_id, $nozzle_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $nozzle = Nozzle::findOrFail($nozzle_id);
            if (!$this->company->petrolPumps->contains('id', $nozzle->petrol_pump_id)) {
                return response()->json(['success' => false, 'message' => 'Access denied to Nozzle.'], 403);
            }
            $nozzle->delete();
            return response()->json(['success' => true, 'message' => 'Nozzle deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Nozzle.'], 500);
        }
    }

}
