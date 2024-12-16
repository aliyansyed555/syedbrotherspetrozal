<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
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
        $pump_id = $this->pump->id;
        return view('client_admin.pump.customer', compact(['pump_id']));
    }

    public function getAll()
    {

        $customers = $this->pump->customers()->get();

        $customers->map(function ($customer) {
            $customer->total_credit = $customer->credits()->sum('balance');
            return $customer;
        });
        
        // dd($customers);

        return response()->json([ 
            'recordsTotal' => $customers->count(),
            'recordsFiltered' => $customers->count(),
            'success' => true,
            'data' => $customers,
        ]);
    }

    public function get_credits($pump_id, $customer_id){
        $customer = Customer::where('petrol_pump_id', $pump_id)->findOrFail($customer_id);
        $credits = $customer->credits()->get();
        // $credits = $this->pump->customer()->credits()->get();
        return view('client_admin.pump.customers.credits', compact('pump_id', 'customer', 'credits'));
    }
    
    public function create(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^(\+92|0)?[3][0-9]{9}$/',
            ],
            'address' => 'required|string|max:255',
        ]);
        $validatedData['petrol_pump_id'] = $this->pump->id;
        $customer = Customer::create($validatedData);
        return response()->json(['success' => true, 'message' => 'Customer created successfully.']);
    }

    
    public function update(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ], 404);
        }
        if ($customer->petrol_pump_id != $this->pump->id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied to Customer.',
            ], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^(\+92|0)?[3][0-9]{9}$/',
            ],
            'address' => 'required|string|max:255',
        ]);

        $customer->name = $validatedData['name'];
        $customer->phone = $validatedData['phone'];
        $customer->address = $validatedData['address'];
        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer updated successfully.']);
    }

    public function delete($pump_id, $customer_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $customer = Customer::findOrFail($customer_id);
            if (!$this->company->petrolPumps->contains('id', $customer->petrol_pump_id)) {
                return response()->json(['success' => false, 'message' => 'Access denied to Customer.'], 403);
            }
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Customer.'], 500);
        }
    }
}
