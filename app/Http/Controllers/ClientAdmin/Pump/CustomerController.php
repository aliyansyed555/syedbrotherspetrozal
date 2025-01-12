<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\CustomerCredit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

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
            // Fetch the last credit entry for the customer
            $lastCredit = $customer->credits()->orderBy('id', 'desc')->first(); // Assuming 'id' is the primary key

            // Set the total_credit to the balance of the last entry or 0 if no entry exists
            $customer->total_credit = $lastCredit ? $lastCredit->balance : 0;

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

    public function get_credits($pump_id, $customer_id)
    {
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

        if ($request->closing_balance) {
            $balance = ($request->transaction_type == 'debit' ? '-' : '+') . (int)$request->closing_balance;

            $customerCredit = CustomerCredit::create([
                'customer_id' => $customer->id,
                'bill_amount' => $balance > 0 ? (int)$request->closing_balance : 0, #plus
                'amount_paid' => $balance < 0 ? (int)$request->closing_balance : 0, #subtract
                'remarks' => '',
                'date' => $request->customer_date ?? now()->toDateString(),
                'balance' => $balance
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Customer created successfully.']);
    }

    public function addCustomerCredit(Request $request)
    {

        $validatedData = $request->validate([
            'date' => 'required',
            'remarks' => 'nullable|string',
        ]);

        $lastEntry = DB::table('customer_credits')
            ->where('customer_id', $request->customer_id)
            ->orderBy('id', 'desc') // Assuming 'id' is the primary key
            ->first();

        $customerCredit = CustomerCredit::create([
            'customer_id' => $request->customer_id,
            'bill_amount' => $request->bill_amount ?? 0, #plus
            'amount_paid' => $request->amount_paid ?? 0, #subtract
            'remarks' => $request->remarks,
            'date' => $request->date,
            'is_special' => 1,
            'balance' => 0, #will update in next step
        ]);

        if ($lastEntry) {
            $newBalance = $lastEntry->balance;
            if ($request->bill_amount) $newBalance = $newBalance + $request->bill_amount;
            if ($request->amount_paid) $newBalance = $newBalance - $request->amount_paid;
        } else
            $newBalance = $request->bill_amount - $request->amount_paid;

        $customerCredit->update([
            'balance' => $newBalance
        ]);

        return back()->with('success', 'Customer credit added successfully.');
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

    public function generate_pdf(Request $request, $pump_id, $customer_id)
    {
        // Generate and download the PDF

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $customer = Customer::where('petrol_pump_id', $pump_id)->findOrFail($customer_id);
        $customer->total_credit = $customer->credits()->sum('balance');
        $credits = $customer->credits()->whereBetween('date', [$start_date, $end_date])->get();

        $pdf = Pdf::loadView('pdfs.customer-credits-history-pdf', [
            'credits' => $credits,
            'customer' => $customer,
        ]);

        $filename = "{$customer->name}-" . now()->format('d-m-Y') . ".pdf";

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
