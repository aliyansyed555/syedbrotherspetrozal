<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account; // Ensure that you have created the Account model

class AccountController extends Controller
{
    public function store()
    {
        return view('accounts'); // Load 'resources/views/accounts.blade.php'
    }

    public function create(Request $request)
    {
        // Validate request data
        $request->validate([
            'date'           => 'required|date',
            'account_title'  => 'required|string|max:255',
            'bank_name'      => 'required|string|max:255',
            'person_name'    => 'required|string|max:255',
            'account_number' => 'required|string|unique:accounts,account_number',
            'previous_cash'  => 'required|numeric|min:0',
            
        ]);

        // Insert into database if validation passes
        $account = new Account();
        $account->date           = $request->date;
        $account->account_title   = $request->account_title;
        $account->bank_name      = $request->bank_name;
        $account->person_name    = $request->person_name;
        $account->account_number = $request->account_number;
        $account->previous_cash  = $request->previous_cash;
        
        $account->save();

        return response()->json(['message' => 'Account created successfully']);
    }
}
