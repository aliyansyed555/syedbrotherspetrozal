<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BankAccount;

// Ensure that you have created the Account model

class BankAccountController extends Controller
{
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

        // Validate request data
        $validated = $request->validate([
            'date' => 'required|date',
            'account_type' => 'required|in:current,saving,other', // Match ENUM values
            'bank_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50|unique:bank_accounts,account_number',
            'previous_cash' => 'required|numeric|min:0',
        ]);

        $bank = null;
        if($request->id){
            $bank = BankAccount::findOrFail($request->id);
        }

        if ($bank)
            $bank->update($validated);
        else
            BankAccount::create($validated);

        return redirect()->back()->with('success', 'Bank Account Created/Updated successfully.');
    }
}
