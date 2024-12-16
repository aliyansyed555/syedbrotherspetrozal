<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class EmployeeController extends Controller
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
        return view('client_admin.pump.employee', compact(['pump_id']));
    }
    function show(Request $request, $pump_id, $employee_id)
    {
        // dd($request->all());
        $pump_id = $this->pump->id; // Assuming $this->pump is already set via middleware or other logic.
        $employee = Employee::findOrFail($employee_id); // Use findOrFail for better error handling.
        $wages = $employee->wages; // Eager load the wages relationship.
    // dd($wages);
        return view('client_admin.pump.employees.show', compact('pump_id', 'employee', 'wages'));
    }

    public function getAll()
    {

        $employees = $this->pump->employees()->get();
        $employees->map(function ($employee) {
            $employee->remaining_salary = $employee->total_salary - $employee->wages()->sum('amount_received');
            return $employee;
        });
        return response()->json([ 
            'recordsTotal' => $employees->count(),
            'recordsFiltered' => $employees->count(),
            'success' => true,
            'data' => $employees,
        ]);
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
            'total_salary' => 'nullable|numeric',
        
        ]);

        $validatedData['petrol_pump_id'] = $this->pump->id;
        $employee = Employee::create($validatedData);

        return response()->json(['success' => true, 'message' => 'Employee created successfully.']);
    }

    
    public function update(Request $request)
    {
        $employee = Employee::findOrFail($request->id);
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }
        if ($employee->petrol_pump_id != $this->pump->id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied to Employee.',
            ], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^(\+92|0)?[3][0-9]{9}$/',
            ],
            'address' => 'required|string|max:255',
            'total_salary' => 'nullable|numeric',
        ]);

        $employee->name = $validatedData['name'];
        $employee->phone = $validatedData['phone'];
        $employee->address = $validatedData['address'];
        if (isset($validatedData['total_salary'])) {
            $employee->total_salary = $validatedData['total_salary'];
        }
        $employee->save();

        return response()->json(['success' => true, 'message' => 'Employee updated successfully.']);
    }

    public function delete($pump_id, $employee_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $employee = Employee::findOrFail($employee_id);
            if (!$this->company->petrolPumps->contains('id', $employee->petrol_pump_id)) {
                return response()->json(['success' => false, 'message' => 'Access denied to Employee.'], 403);
            }
            $employee->delete();
            return response()->json(['success' => true, 'message' => 'Employee deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Employee.'], 500);
        }
    }
}

