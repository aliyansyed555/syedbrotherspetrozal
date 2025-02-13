<?php

namespace App\Http\Controllers;

use App\Models\BankAccountCredit;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

// Ensure that you have created the Account model

class BankAccountController extends Controller
{
    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
    }

    public function index()
    {
        return view('bank-accounts.index');
    }

    public function getAll()
    {

        $accounts = BankAccount::where('id', '>', 0)->get();

//        $customers->map(function ($customer) {
//            // Fetch the last credit entry for the customer
//            $lastCredit = $customer->credits()->orderBy('id', 'desc')->first(); // Assuming 'id' is the primary key
//
//            // Set the total_credit to the balance of the last entry or 0 if no entry exists
//            $customer->total_credit = $lastCredit ? $lastCredit->balance : 0;
//
//            return $customer;
//        });


        // dd($customers);

        return response()->json([
            'recordsTotal' => $accounts->count(),
            'recordsFiltered' => $accounts->count(),
            'success' => true,
            'data' => $accounts,
        ]);
    }


    public function create(Request $request)
    {
        try {
            // Validate request data using the shared validation function
            $validated = $this->validateBankAccount($request);

            BankAccount::create($validated);

            return response()->json(['success' => true, 'message' => 'Account created successfully.']);

        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' line ' . $e->getLine());
            return response()->json(['success' => false, 'message' => 'An error occurred while creating account.'], 500);
        }
    }

    public function update(Request $request)
    {
        $account = BankAccount::find($request->id);
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'BankAccount not found.',
            ], 404);
        }

        // Validate request data using the shared validation function
        $validated = $this->validateBankAccount($request, $account->id);

        $account->update($validated);

        return response()->json(['success' => true, 'message' => 'Bank Account updated successfully.']);
    }

    /**
     * Validate bank account request data.
     *
     * @param Request $request
     * @param int|null $accountId
     * @return array
     */
    private function validateBankAccount(Request $request, $accountId = null): array
    {
        $rules = [
            'date' => 'required|date',
            'account_type' => 'required|in:current,saving,other', // Match ENUM values
            'bank_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'account_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bank_accounts', 'account_number')->ignore($accountId), // Ignore if updating
            ],
            'previous_cash' => 'required|numeric|min:0',
        ];

        return $request->validate($rules);
    }

    public function delete($account_id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            $account = BankAccount::findOrFail($account_id);

            $account->delete();
            return response()->json(['success' => true, 'message' => 'Account deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Account.'], 500);
        }
    }

    public function get_credit_detail($account_id)
    {
        $startDate = request('start_date');
        $endDate = request('end_date');

        $account = BankAccount::findOrFail($account_id);

        $accounts = BankAccount::where('id', '<>', $account_id)
            ->select('id', 'person_name', 'account_number', 'bank_name')
            ->get();

        $creditsQuery = \DB::table('bank_account_credits')
            ->leftJoin('bank_accounts as revise_accounts', 'bank_account_credits.revise_account_id', '=', 'revise_accounts.id')
            ->where('bank_account_credits.bank_account_id', $account_id)
            ->select(
                'bank_account_credits.*',
                'revise_accounts.person_name as revise_person_name',
                'revise_accounts.account_number as revise_account_number',
                'revise_accounts.bank_name as revise_bank_name'
            );

        // **Apply date filter only if both start and end dates are provided**
        if ($startDate && $endDate) {
            $creditsQuery->whereBetween('bank_account_credits.date', [$startDate, $endDate]);
        }

        $credits = $creditsQuery->get();

        return view('bank-accounts.credits', compact('account', 'credits', 'accounts'));
    }

    public function addBankAccountCredit(Request $request)
    {

        $validated = $request->validate([
            'revise_account_id' => 'required|exists:bank_accounts,id', // Ensure account_id exists in the bank_accounts table
            'date' => 'required|date', // Validate date format
            'amount' => 'required|numeric|min:0', // Ensure amount is a valid number
            'remarks' => 'nullable|string|max:255', // Remarks can be optional and a string
            'type' => 'required|in:received,transfer', // Ensure it matches ENUM values
            'bank_account_id' => 'required|exists:bank_accounts,id', // Ensure it matches ENUM values
        ]);

        BankAccountCredit::create($validated);

        $account = BankAccount::findOrFail($validated['bank_account_id']);

        $account->previous_cash += ($validated['type'] === 'received') ? $validated['amount'] : -$validated['amount'];
        $account->save();

        return redirect()->back()->with('success', 'Bank Account Credit created successfully.');
    }
}
