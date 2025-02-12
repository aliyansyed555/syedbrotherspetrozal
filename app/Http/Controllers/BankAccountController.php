<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'date' => 'required|date',
            'account_title' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'account_number' => 'required|string|unique:accounts,account_number',
            'previous_cash' => 'required|numeric|min:0',

        ]);

        // Insert into database if validation passes
        $account = new Account();
        $account->date = $request->date;
        $account->account_title = $request->account_title;
        $account->bank_name = $request->bank_name;
        $account->person_name = $request->person_name;
        $account->account_number = $request->account_number;
        $account->previous_cash = $request->previous_cash;

        $account->save();

        return response()->json(['message' => 'Account created successfully']);
    }
}
