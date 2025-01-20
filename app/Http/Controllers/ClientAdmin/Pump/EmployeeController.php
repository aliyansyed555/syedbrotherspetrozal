<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function revise_salaries(){
        $employees = $this->pump->employees()->get();

        foreach ($employees as $employee){

            $lastMonth = now()->subMonth(); #this will work for last month, if we want to do current month then we can update here to NOW

            // Check if the balance was already calculated for this month
            if ($employee->last_calculated_at && date('Y-m', strtotime($employee->last_calculated_at)) == $lastMonth->format('Y-m')) {
               continue;
            }

            // Calculate total wages for the current month
            $currentMonthWages = DB::table('employee_wages')
                ->where('employee_id', $employee->id)
                ->whereYear('date', $lastMonth->year)
                ->whereMonth('date', $lastMonth->month)
                ->sum('amount_received');

            // Calculate the balance
            $remaining_balance = $employee->remaining_balance + ($employee->total_salary - $currentMonthWages);

            // Update the employee's profile
            #$currentMonthYear = $lastMonth->format('Y-m');
            DB::table('employees')
                ->where('id', $employee->id)
                ->update([
                    'remaining_balance' => $remaining_balance,
                    'last_calculated_at' => $lastMonth,
                ]);
        }

        return back()->with('success', 'Salaries updated successfully.');
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
        return view('client_admin.pump.employees.show', compact('pump_id', 'employee', 'wages'));
    }

    public function getAll()
    {
        $employees = $this->pump->employees()->get();

        $selectedMonth = now()->month; // Or replace with a specific month, e.g., 1 for January

        $employees->map(function ($employee) use ($selectedMonth) {
            // Get the total wages for the selected month
            $wagesForMonth = $employee->wages()
                ->whereMonth('date', $selectedMonth)
                ->sum('amount_received'); // Sum wages for the specific month

            // Calculate remaining salary for the selected month
            $employee->remaining_salary = $employee->total_salary - $wagesForMonth + $employee->remaining_balance;
        });



        # # + $employee->remaining_balance

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
            'total_salary' => 'nullable|numeric'
        ]);

        $validatedData['petrol_pump_id'] = $this->pump->id;
        $employee = Employee::create($validatedData);

        if ($request->advance_salary)
            DB::table('employee_wages')->insert([
                'employee_id' => $employee->id,
                'amount_received' => (int)$request->advance_salary,
                'date' => $request->employee_date ?? now()->toDateString(),
            ]);

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

        if ($request->advance_salary){
            DB::table('employee_wages')->insert([
                'employee_id' => $employee->id,
                'amount_received' => (int)$request->advance_salary,
                'date' => $request->employee_date ?? now()->toDateString(),
            ]);
        }

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

    public function generate_pdf(Request $request, $pump_id, $employee_id)
    {
        // Generate and download the PDF

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $employee = Employee::findOrFail($employee_id);
        $wages = $employee->wages()->whereBetween('date', [$start_date, $end_date])->get();

        $pdf = Pdf::loadView('pdfs.employee-wages-history-pdf', [
            'wages' => $wages,
            'employee' => $employee,
        ]);


        // repeated code
        $filename = "{$employee->name}-" . now()->format('d-m-Y') . ".pdf";

        $directory = public_path('storage/random_pdfs');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);  // Create the directory if it doesn't exist
        }

        // Save the PDF to the specified directory
        $pdfPath = $directory . '/' . $filename;
        $pdf->save($pdfPath);

        // Check if you want to send the file as a response (AJAX)
        if ($request->ajax()) {
            // Return the file URL in the response
            $fileUrl = asset('storage/random_pdfs/' . $filename);
            return response()->json([
                'status' => 'success',
                'file_url' => $fileUrl, // Provide the URL to the saved PDF
            ]);
        }

        // If not an AJAX request, download the PDF directly
        return response()->download($pdfPath, $filename, [
            'Content-Type' => 'application/pdf',
        ])->deleteFileAfterSend(false);
    }
}

