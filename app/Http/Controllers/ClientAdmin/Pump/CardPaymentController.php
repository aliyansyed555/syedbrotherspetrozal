<?php

namespace App\Http\Controllers\ClientAdmin\Pump;

use App\Http\Controllers\Controller;
use App\Models\CardPayment;
use Auth;
use Illuminate\Http\Request;

class CardPaymentController extends Controller
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
    function index()
    {
        $card_transactions = $this->pump->cardPayments()->get();
        $pump_id = $this->pump->id;
        return view('client_admin.pump.card-transactions', compact(['card_transactions', 'pump_id']));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'account_number' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $validatedData['card_number'] = 'xxxx-xxxx-xxxx-xxxx';
        $validatedData['transaction_type'] = 'withdrawal';
        $validatedData['petrol_pump_id'] = $this->pump->id;
        $validatedData['amount'] = - $validatedData['amount'];

        $card_payment = CardPayment::create($validatedData);
        
        return response()->json(['success' => true, 'message' => 'Card Payment created successfully.']);
    }
}
