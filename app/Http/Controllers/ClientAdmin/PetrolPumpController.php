<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\BankDeposit;
use App\Models\DailyReport;
use App\Models\DipComparison;
use App\Models\DipRecord;
use App\Models\FuelPrice;
use App\Models\FuelType;
use App\Models\PetrolPump;
use App\Models\NozzleReading;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PetrolPumpController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        // Initialize the user and company properties
        $this->user = Auth::user();
        $this->company = get_company($this->user);
    }

    function index()
    {
        return view('client_admin.pumps');
    }

    public function updateInvestment(Request $request, $id)
    {
        $pump = PetrolPump::where('id', $id)->first();
        $pump->total_investment = $request->input('total_investment');
        $pump->save();

        return redirect()->back()->with('success', 'Total Investment updated successfully.');
    }

    public function refreshDipCamparision(Request $request)
    {
        $pump_id = $request->pump->id;
        $dataAll = $request->all()['rows'];

        foreach ($dataAll as $data) {
            DipComparison::updateOrCreate(
                [
                    // Matching condition
                    'report_date' => $data['report_date'],
                    'fuel_type_id' => $data['fuel_type_id'],
                    'pump_id' => $pump_id,
                ],
                [
                    // Fields to update or insert
                    'tank_dip' => $data['tank_dip'],
                    'tank_stock' => $data['tank_stock'],
                    'previous_stock' => $data['previous_stock'],
                    'final_dip' => $data['final_dip'],
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Stats updated successfully!']);
    }

    public function showAnalytics($pump_id)
    {

        $startDate = request('start_date', now()->toDateString());
        $endDate = request('end_date', now()->toDateString());

        $pump = PetrolPump::where('id', $pump_id)->first();

        $fuelPurchasesPrices = $pump->fuelPurchases()
            ->join('fuel_types', 'fuel_types.id', '=', 'fuel_purchases.fuel_type_id')
            ->whereDate('purchase_date', '<=', $endDate) // Apply the date range filter
            ->select('fuel_types.id', 'fuel_purchases.buying_price_per_ltr') // Select only required fields
            ->pluck('buying_price_per_ltr', 'id')
            ->toArray();

        $pump = PetrolPump::where('id', $pump_id)->first();

        $tanks = $pump->tanks();

        $stocks = DipRecord::select(
            'dip_records.date',
            'dip_records.tank_id',
            'tanks.fuel_type_id', // Include in GROUP BY
            'tanks.name as tank_name', // Include in GROUP BY
            DB::raw('SUM(dip_records.reading_in_ltr) as total_reading_in_ltr')
        )
            ->join('tanks', 'dip_records.tank_id', '=', 'tanks.id')
            ->whereIn('dip_records.tank_id', $tanks->pluck('id'))
            ->whereBetween('dip_records.date', [$startDate, $endDate]) // Filter by date range
            ->where('dip_records.date', function ($query) use ($startDate, $endDate) {
                $query->select(DB::raw('MAX(date)'))
                    ->from('dip_records')
                    ->whereColumn('dip_records.tank_id', 'tank_id')
                    ->whereBetween('dip_records.date', [$startDate, $endDate]); // Add date range here too
            })
            ->groupBy('dip_records.date', 'dip_records.tank_id', 'tanks.fuel_type_id', 'tanks.name') // Include all selected columns
            ->get();

//        $tanks = $pump->tanks()
//            ->withSum('tankStocks as total_stock', 'reading_in_ltr')
//            ->get();
//
//        $tanks = $tanks->map(function ($tank) {
//            $fuelType = DB::table('fuel_types')->find($tank->fuel_type_id);
//            $tank->fuel_type_name = $fuelType ? $fuelType->name : null;
//            return $tank;
//        });

        $products = $pump->products()
            ->selectRaw('products.id, products.name, products.price, products.buying_price, products.company, coalesce((select sum(quantity) from product_inventory where product_id = products.id and product_inventory.date <= ?), 0) as quantity', [$endDate])
            ->get();

        $cashInhand = \DB::table('daily_reports')
            ->where('petrol_pump_id', $pump->id)
            ->latest('date')
            ->value('cash_in_hand');

        $customers = $pump->customers()->get();

        $creditsAndDebits = $customers->map(function ($customer) use ($startDate, $endDate) {
            $lastCredit = $customer->credits()
                ->whereBetween('date', [$startDate, $endDate]) // Apply date filter
                ->orderBy('id', 'desc')
                ->first();
            $customer->total_credit = $lastCredit ? $lastCredit->balance : 0;
            return $customer;
        })->reduce(function ($totals, $customer) {
            if ($customer->total_credit > 0) {
                $totals['credit'] += $customer->total_credit; // Add positive balances to credit
            } elseif ($customer->total_credit < 0) {
                $totals['debit'] += abs($customer->total_credit); // Add absolute values of negative balances to debit
            }
            return $totals;
        }, ['credit' => 0, 'debit' => 0]);

        $totalCredit = $creditsAndDebits['credit'];
        $totalDebit = $creditsAndDebits['debit'];

        list($profits, $fuelGain, $gainProfit, $totalProfit, $totalGain, $totalSold) = $this->getAnalyticsProfitsData($pump, $startDate, $endDate);


        $mobilOilProfit = @$profits['products_profit'];
        unset($profits['products_profit']);

        $totalWagesSum = DB::table('employee_wages')
            ->join('employees', 'employee_wages.employee_id', '=', 'employees.id')
            ->where('employees.petrol_pump_id', $pump_id)
            ->whereBetween('employee_wages.date', [$startDate, $endDate])
            ->sum('employee_wages.amount_received');

        $dailyExpenses = DB::table('daily_reports')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('petrol_pump_id', $pump_id)
            ->selectRaw('COALESCE(SUM(daily_expense), 0) as daily_expense_sum,COALESCE(SUM(pump_rent), 0) as pump_rent_sum')
            ->first();

        $dailyExpenses->total_wages_sum = $totalWagesSum;

        $shopEarnings = DB::table('daily_reports')
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
        COALESCE(
            SUM(tuck_shop_rent + tuck_shop_earning +
                service_station_earning + service_station_rent +
                tyre_shop_earning + tyre_shop_rent +
                lube_shop_earning + lube_shop_rent), 0
        ) as total_sum,
        COALESCE(SUM(tuck_shop_rent), 0) as tuck_shop_rent,
        COALESCE(SUM(tuck_shop_earning), 0) as tuck_shop_earning,
        COALESCE(SUM(service_station_earning), 0) as service_station_earning,
        COALESCE(SUM(service_station_rent), 0) as service_station_rent,
        COALESCE(SUM(tyre_shop_earning), 0) as tyre_shop_earning,
        COALESCE(SUM(tyre_shop_rent), 0) as tyre_shop_rent,
        COALESCE(SUM(lube_shop_earning), 0) as lube_shop_earning,
        COALESCE(SUM(lube_shop_rent), 0) as lube_shop_rent
    ')
            ->first();

        #because when we add fuel prices we use 1+ day because rate will use next day, but here we need that previouse day profit in current end date so we add 1 extra day to get that date
        #$dayAfterEndDate = Carbon::parse($endDate)->addDay()->toDateString();
        $total_loss_gain = FuelPrice::where('petrol_pump_id', $pump_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->join('fuel_types', 'fuel_prices.fuel_type_id', '=', 'fuel_types.id')
            ->select(
                'fuel_types.name as fuel_name',
                DB::raw('SUM(fuel_prices.loss_gain_value) as total_loss_gain')
            )
            ->groupBy('fuel_types.name')
            ->orderBy('fuel_types.name', 'asc')
            ->get();

        $sumLossGain = FuelPrice::where('petrol_pump_id', $pump_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('loss_gain_value');

        $final_profit = $totalProfit;
        $final_profit_with_gain = $totalProfit + $totalGain;

        $total_arrivals = $pump->fuelPurchases()
            ->whereBetween('fuel_purchases.purchase_date', [$startDate, $endDate])
            ->join('fuel_types', 'fuel_types.id', '=', 'fuel_purchases.fuel_type_id')
            ->select(
                'fuel_types.name as fuel_type_name',
                DB::raw('SUM(fuel_purchases.quantity_ltr) as total_quantity_ltr')
            )
            ->groupBy('fuel_types.name')
            ->get();

        $cashInhand = \DB::table('daily_reports')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('petrol_pump_id', $pump->id)
            ->sum('cash_in_hand');

        return view('client_admin.pump.analytics', compact(
            'pump',
            'stocks',
            'products',
            'cashInhand',
            'totalCredit',
            'totalDebit',
            'profits',
            'mobilOilProfit',
            'fuelGain',
            'gainProfit',
            'dailyExpenses',
            'shopEarnings',
            'total_loss_gain',
            'sumLossGain',
            'final_profit',
            'final_profit_with_gain',
            'total_arrivals',
            'totalSold',
            'fuelPurchasesPrices',
            'cashInhand',
        ));
    }

    function get_expenses($pump_id)
    {
        $expense_data = DB::table('daily_reports as dr')
            ->leftJoin('bank_deposits as bd', function ($join) {
                $join->on('dr.date', '=', 'bd.date')
                    ->on('dr.petrol_pump_id', '=', 'bd.pump_id');
            })
            ->select(
                'dr.date',
                'dr.daily_expense',
                'dr.pump_rent',
                'bd.expense_detail',
                'bd.account_number',
                DB::raw('SUM(bd.bank_deposit) as bank_deposit')
            )
            ->where('dr.petrol_pump_id', $pump_id)
            ->groupBy('dr.date', 'dr.daily_expense', 'dr.pump_rent', 'bd.expense_detail', 'bd.account_number')
            ->union(
                DB::table('bank_deposits as bd')
                    ->leftJoin('daily_reports as dr', function ($join) {
                        $join->on('bd.date', '=', 'dr.date')
                            ->on('bd.pump_id', '=', 'dr.petrol_pump_id');
                    })
                    ->select(
                        'bd.date',
                        'dr.daily_expense',
                        'dr.pump_rent',
                        'bd.expense_detail',
                        'bd.account_number',
                        DB::raw('SUM(bd.bank_deposit) as bank_deposit')
                    )
                    ->where('bd.pump_id', $pump_id)
                    ->groupBy('bd.date', 'dr.daily_expense', 'dr.pump_rent', 'bd.expense_detail', 'bd.account_number')
            )
            ->orderBy('date')
            ->get();

        return view('client_admin.pump.expenses', compact('expense_data', 'pump_id'));
    }

    function save_bank_deposit(Request $request)
    {
        $pump_id = $request->pump->id;
        // dd($pump_id);

        $validatedData = $request->validate([
            'date' => 'required|date',
            'bank_deposit' => 'required|numeric',
            'account_number' => 'required|numeric',
            'expense_detail' => 'required|string',
        ], [
            'date.required' => 'Date is required.',
            'date.date' => 'Date must be a valid date.',
            'bank_deposit.required' => 'Bank Deposit is required.',
            'bank_deposit.numeric' => 'Bank Deposit must be a number.',
            'account_number.required' => 'Account Number is required.',
            'account_number.numeric' => 'Account Number must be a number.',
            'expense_detail.required' => 'Expense Detail is required.',
            'expense_detail.string' => 'Expense Detail must be a string.',
        ]);

        BankDeposit::updateOrCreate(
            [
                'date' => $validatedData['date'],
                'pump_id' => $pump_id,
            ],
            [
                'bank_deposit' => -$validatedData['bank_deposit'],
                'account_number' => $validatedData['account_number'],
                'expense_detail' => $validatedData['expense_detail'],
            ]
        );

        return response()->json(['success' => true, 'message' => 'Amount Transferred successfully.']);
    }

    function get_sales_history($pump_id)
    {
        $pump = PetrolPump::where('id', $pump_id)->first();
        $orders = $pump->productSales()->get();

        return view('client_admin.pump.sales-history', compact('orders'));

    }

    function show($pumpId)
    {
        $pump = PetrolPump::where('id', $pumpId)->first();

        if (!$pump) {
            return view('errors.404');
        }

        $tanks = $pump->tanks()->get();

        $nozzles = $pump->nozzles()->with([
            'fuelType',
            'nozzleReadings' => function ($query) {
                $query->orderBy('id', 'desc')->take(1);
            }
        ])->get();

        $fuelPrices = $pump->fuelPrices()
            ->join('fuel_types', 'fuel_prices.fuel_type_id', '=', 'fuel_types.id')
            ->where('fuel_types.company_id', $this->company->id)
            ->selectRaw('fuel_prices.fuel_type_id, MAX(fuel_prices.id) as id')
            ->groupBy('fuel_prices.fuel_type_id')
            ->get()
            ->map(function ($row) use ($pump) {
                $fuelPrice = $pump->fuelPrices()
                    ->where('fuel_type_id', $row->fuel_type_id)
                    ->where('id', $row->id)
                    ->first(['fuel_type_id', 'selling_price', 'date']);

                $fuelPrice->fuel_type_name = $fuelPrice->fuelType->name;
                return $fuelPrice;
            })
            ->toArray();

        $stocks = $pump->tanks()
            ->join('tank_stocks', 'tank_stocks.tank_id', '=', 'tanks.id')  // Join tank_stocks to tanks
            ->join('fuel_types', 'fuel_types.id', '=', 'tanks.fuel_type_id') // Join fuel_types to tanks
            ->selectRaw('fuel_types.name as fuel_type_name, tanks.fuel_type_id, SUM(tank_stocks.reading_in_ltr) as total_stock')
            ->groupBy('fuel_types.name', 'tanks.fuel_type_id')  // Group by fuel_type_id and fuel_type_name
            ->get();

        $pump_id = $pump->id;


        $cashInHand = \DB::table('daily_reports')
            ->where('petrol_pump_id', $pump->id)
            ->latest('date')
            ->value('cash_in_hand');

        return view('client_admin.pump.show', compact('pump', 'nozzles', 'fuelPrices', 'pump_id', 'cashInHand', 'stocks', 'tanks'));
    }

    public function getProducts($pumpId)
    {
        $pump = PetrolPump::where('id', $pumpId)->first();

        if (!$pump) {
            return response()->json([
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'success' => false,
                'message' => 'Petrol Pump not found.',
            ], 404);
        }

        $products = $pump->products()->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function getEmployees($pumpId)
    {
        $pump = PetrolPump::where('id', $pumpId)->first();

        if (!$pump) {
            return response()->json([
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'success' => false,
                'message' => 'Petrol Pump not found.',
            ], 404);
        }

        $employees = $pump->employees()->get();

        return response()->json([
            'success' => true,
            'data' => $employees,
        ]);
    }

    public function getCustomers($pumpId)
    {
        $pump = PetrolPump::where('id', $pumpId)->first();

        if (!$pump) {
            return response()->json([
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'success' => false,
                'message' => 'Petrol Pump not found.',
            ], 404);
        }

        $customers = $pump->customers()->get();

        return response()->json([
            'success' => true,
            'data' => $customers,
        ]);
    }

    public function get_all()
    {
        $petrol_pump = $this->company->petrolPumps;
        $record_count = $petrol_pump->count();
        return response()->json([
            'recordsTotal' => $record_count,
            'recordsFiltered' => $record_count,
            'success' => true,
            'data' => $petrol_pump,
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'created_date' => 'required',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required.',
            'location.required' => 'Location field is required.',
            'created_date.required' => 'Date is required for cash in hand report.',
        ]);

        $pump = PetrolPump::create([
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'company_id' => $this->company->id,
            'total_investment' => $request->total_investment,
        ]);

        if ($request->cash_in_hand)
            DB::table('daily_reports')->insert([
                'date' => $request->created_date ?? now()->toDateString(),
                'petrol_pump_id' => $pump->id,
                'cash_in_hand' => $request->cash_in_hand,
            ]);

        return response()->json(['success' => true, 'message' => 'Petrol Pump created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required.',
            'location.required' => 'Email field is required.',
        ]);

        // Find the user by ID and update their details
        $petrol_pump = PetrolPump::findOrFail($id);
        $updateData = [
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'total_investment' => $request->total_investment,
        ];

        $petrol_pump->update($updateData);

        if ($request->cash_in_hand)
            DB::table('daily_reports')->updateOrInsert(
                [
                    'date' => $request->created_date ?? now()->toDateString(),
                    'petrol_pump_id' => $id,
                ],
                [
                    'cash_in_hand' => $request->cash_in_hand,
                    'updated_at' => now(), // Optional: If you want to track updates
                ]
            );

        return response()->json(['success' => true, 'message' => 'Petrol Pump updated successfully.']);
    }

    public function delete($id)
    {
        if (!$this->user->can('owner-access')) {
            return response()->json(['success' => false, 'message' => 'You do not have permission to delete this.'], 403);
        }
        try {
            // Find the user by ID
            $petrol_pump = PetrolPump::findOrFail($id);

            // Check owner access
            if ($petrol_pump->company_id != $this->company->id) {
                return response()->json(['success' => false, 'message' => 'You do not have the necessary permissions.'], 403);
            }

            // Delete the user
            $petrol_pump->delete();
            // Return success response
            return response()->json(['success' => true, 'message' => 'Petrol Pump deleted successfully.']);
        } catch (\Exception $e) {
            // Return error response for any other exceptions
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the Petrol Pump.'], 500);
        }
    }


    // public function saveReport(Request $request){
    //     dd($request->all());
    // }


    public function saveReport(Request $request, $id)
    {
        // dd($request->all());
        // $request->validate([
        //     'date' => [
        //         'required',
        //         'date',
        //         Rule::unique('daily_reports')->where(function ($query) use ($id) {
        //             return $query->where('petrol_pump_id', $id);
        //         }),
        //     ],
        // ], [
        //     'date.unique' => 'The date must be unique for this petrol pump.',
        // ]);

        $petrol_pump = PetrolPump::findOrFail($id);

        DB::beginTransaction(); // Start the transaction

        try {
            $date = $request->input('date');
            $petrolPumpId = $petrol_pump->id;
            // dd($petrolPumpId, $date);

            // 1. Save nozzle readings
            if ($request->has('tank_transfers')) {

                $tank_transfers = $request->input('tank_transfers');
                foreach ($tank_transfers as $tankId => $reading) {
                    DB::table('tank_transfers')->insert([
                        'tank_id' => $tankId,
                        'quantity_ltr' => $reading['quantity_ltr'] ?? 0,
                        'date' => $date,
                    ]);
                }
            }

            if ($request->has('readings')) {
                // Initialize an array to hold the total sold fuel for each tank
                $tankSales = [];

                foreach ($request->input('readings') as $nozzleId => $reading) {

                    $nozzle = DB::table('nozzles')->where('id', $nozzleId)->first();
                    $tankId = $nozzle->tank_id; // Get the tank_id from the nozzle

                    $previousReading = DB::table('nozzle_readings')
                        ->where('nozzle_id', $nozzleId)
                        ->orderBy('id', 'desc')
                        ->first();

                    $amountSoldToday = 0;
                    if ($previousReading) {
                        $amountSoldToday = $reading['digital_reading'] - $previousReading->digital_reading;
                    } else {
                        $amountSoldToday = $reading['digital_reading'];
                    }

                    if (isset($tankSales[$tankId])) {
                        $tankSales[$tankId] += $amountSoldToday;
                    } else {
                        $tankSales[$tankId] = $amountSoldToday;
                    }

                    NozzleReading::create([
                        'nozzle_id' => $nozzleId,
                        'analog_reading' => $reading['analog_reading'],
                        'digital_reading' => $reading['digital_reading'],
                        'date' => $date,
                    ]);

                }
                foreach ($tankSales as $tankId => $totalSold) {
                    // Check if there are tank transfers for this tank
                    $transferQuantity = DB::table('tank_transfers')
                        ->where('tank_id', $tankId)
                        ->whereDate('date', '=', $date) // Consider transfers before or on the date
                        ->sum('quantity_ltr'); // Sum transferred quantities

                    // Adjust total sold by subtracting the transfer quantity
                    $adjustedSold = $totalSold - $transferQuantity;

                    DB::table('tank_stocks')->insert([
                        'tank_id' => $tankId,
                        'reading_in_ltr' => -$adjustedSold, // Use negative value to deduct stock
                        'date' => $date,
                    ]);
                }
            }


            // 2. Save customer credits
            if ($request->has('allCredits')) {
                foreach ($request->input('allCredits') as $credit) {
                    $lastEntry = DB::table('customer_credits')
                        ->where('customer_id', $credit['customer_id'])
                        ->orderBy('id', 'desc') // Assuming 'id' is the primary key
                        ->first();

                    if ($lastEntry) {
                        $newBalance = $lastEntry->balance;
                        if ($credit['bill_amount']) $newBalance = $newBalance + $credit['bill_amount'];
                        if ($credit['amount_paid']) $newBalance = $newBalance - $credit['amount_paid'];
                    } else
                        $newBalance = $credit['bill_amount'] - $credit['amount_paid'];

                    DB::table('customer_credits')->insert([
                        'customer_id' => $credit['customer_id'],
                        'bill_amount' => $credit['bill_amount'],
                        'amount_paid' => $credit['amount_paid'],
                        'balance' => $newBalance, #totalCredit
                        'remarks' => $credit['remarks'],
                        'date' => $date,
                    ]);
                }
            }

            // 3. Save card payments
            if ($request->has('allCardPayments')) {
                foreach ($request->input('allCardPayments') as $payment) {
                    DB::table('card_payments')->insert([
                        'card_number' => $payment['card_number'],
                        'amount' => $payment['amount'],
                        'card_type' => $payment['card_type'],
                        'petrol_pump_id' => $petrolPumpId,
                        'date' => $date,
                    ]);
                }
            }

            // 4. Save employee wages
            if ($request->has('givenWages')) {
                foreach ($request->input('givenWages') as $wage) {
                    DB::table('employee_wages')->insert([
                        'employee_id' => $wage['employee_id'],
                        'amount_received' => $wage['amount_received'],
                        'date' => $date,
                    ]);
                }
            }

            // 5. Save sold products
            if ($request->has('soldProducts')) {
                $soldProducts = $request->input('soldProducts');
                $totalAmount = array_sum(array_column($soldProducts, 'total'));
                // $productIds = array_column($soldProducts, 'id');

                $productData = array_map(function ($product) {
                    return [
                        'product_id' => $product['id'],
                        'product_name' => $product['name'],
                        'product_price' => $product['price'],
                        'buying_price' => $product['buying_price'],
                        'product_qty' => $product['quantity'],
                        'total' => $product['total'],
                    ];
                }, $soldProducts);

                $profitAmount = array_sum(array_map(function ($product) {
                    return $product['total'] - ($product['quantity'] * $product['buying_price']);
                }, $soldProducts));

                // Deduct sold product quantities from product inventory
                foreach ($soldProducts as $product) {
                    DB::table('product_inventory')->insert([
                        'product_id' => $product['id'],
                        'quantity' => -$product['quantity'], // Insert with negative sign to deduct
                        'date' => $date,
                    ]);
                }

                DB::table('product_sales')->insert([
                    'amount' => $totalAmount,
                    'profit' => $profitAmount,
                    'product_data' => json_encode($productData),
                    'petrol_pump_id' => $petrolPumpId,
                    'date' => $date,
                ]);

            }

            // 6. Save daily report TODO: check and test if works fine then ok otherwise we will only create
            // Check date with petrolPumpId and update or create accordingly
            DB::table('daily_reports')->updateOrInsert(
                [
                    // Matching criteria
                    'date' => $date,
                    'petrol_pump_id' => $petrolPumpId,
                ],
                [
                    // Values to update or insert
                    'daily_expense' => $request->input('daily_expense'),
//                    'bank_deposit' => $request->input('bank_deposit'),
//                    'expense_detail' => $request->input('expense_detail'),
//                    'account_number' => $request->input('account_number'),
                    'pump_rent' => $request->input('pump_rent'),
                    'cash_in_hand' => $request->input('cashInHand') ?? 0,

                    // New fields
                    'tuck_shop_rent' => $request->input('tuck_shop_rent') ?? 0,
                    'tuck_shop_earning' => $request->input('tuck_shop_earning') ?? 0,
                    'service_station_earning' => $request->input('service_station_earning') ?? 0,
                    'service_station_rent' => $request->input('service_station_rent') ?? 0,
                    'tyre_shop_earning' => $request->input('tyre_shop_earning') ?? 0,
                    'tyre_shop_rent' => $request->input('tyre_shop_rent') ?? 0,
                    'lube_shop_earning' => $request->input('lube_shop_earning') ?? 0,
                    'lube_shop_rent' => $request->input('lube_shop_rent') ?? 0,
                ]
            );

            if ($request->input('bank_deposit') && $request->input('account_number'))
                BankDeposit::updateOrCreate(
                    [
                        'date' => $date,
                        'pump_id' => $petrolPumpId,
                    ],
                    [
                        'bank_deposit' => $request->input('bank_deposit'),
                        'account_number' => $request->input('account_number'),
                        'expense_detail' => $request->input('expense_detail'),
                    ]
                );

            DB::commit(); // Commit the transaction

            return response()->json(['message' => 'Data saved successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPumpReport($petrolPumpId)
    {
        $pumpId = $petrolPumpId;

        // Get the fuel types associated with the petrol pump
        $fuelTypesWithTanks = DB::table('fuel_types')
            ->select('fuel_types.name', 'fuel_types.id')
            ->join('tanks', 'fuel_types.id', '=', 'tanks.fuel_type_id')
            ->join('petrol_pumps', 'tanks.petrol_pump_id', '=', 'petrol_pumps.id')
            ->where('petrol_pumps.company_id', $this->company->id)
            #->limit(1)
            ->distinct()
            ->get();

        $selectClauses = [];
        foreach ($fuelTypesWithTanks as $fuelType) {
            $fuelTypeName = $fuelType->name;
            $fuelTypeId = $fuelType->id;
            $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelTypeName));

            $selectClauses[] = "
            SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN ABS(cr.digital_sold_ltrs) ELSE 0 END) AS `{$columnBase}_digital_sold`,
            SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN ABS(cr.analog_sold_ltrs) ELSE 0 END) AS `{$columnBase}_analog_sold`,
            MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.selling_price ELSE 0 END) AS `{$columnBase}_price`,
            MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.buying_price_per_ltr ELSE NULL END) AS `{$columnBase}_buying_price`,
            MAX(CASE WHEN ts.fuel_type_id = $fuelTypeId THEN ts.cumulative_quantity ELSE 0 END) AS `{$columnBase}_stock_quantity`,
            MAX(CASE WHEN ds.fuel_type_id = $fuelTypeId THEN ds.dip_quantity ELSE 0 END) AS `{$columnBase}_dip_quantity`,
            MAX(CASE WHEN tt.fuel_type_id = $fuelTypeId THEN tt.quantity_ltr ELSE 0 END) AS `{$columnBase}_transfer_quantity`
        ";
        }

        $query = "
    WITH calculated_readings AS (
        SELECT
            nr.nozzle_id,
            nr.date,
            ft.id AS fuel_type_id,
            nr.digital_reading - COALESCE(
                LAG(nr.digital_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date , nr.id desc),
                digital_reading
            ) AS digital_sold_ltrs,
            nr.analog_reading - COALESCE(
                LAG(nr.analog_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date , nr.id desc),
                analog_reading
            ) AS analog_sold_ltrs,
            fr.selling_price,
            (
                SELECT fp.buying_price_per_ltr
                FROM fuel_purchases fp
                WHERE fp.fuel_type_id = ft.id
                  AND fp.petrol_pump_id = ?
                  AND fp.purchase_date <= nr.date
                ORDER BY fp.purchase_date DESC
                LIMIT 1
            ) AS buying_price_per_ltr
        FROM
            nozzle_readings nr
        JOIN
            nozzles n ON nr.nozzle_id = n.id
        JOIN
            fuel_types ft ON n.fuel_type_id = ft.id
        LEFT JOIN
            fuel_prices fr ON fr.fuel_type_id = n.fuel_type_id
            AND fr.petrol_pump_id = n.petrol_pump_id
            AND fr.date = (
                SELECT MAX(fp.date)
                FROM fuel_prices fp
                WHERE fp.fuel_type_id = fr.fuel_type_id
                AND fp.petrol_pump_id = fr.petrol_pump_id
                AND fp.date <= nr.date
            )
        WHERE
            fr.petrol_pump_id = ?
    ),
    tank_stocks AS (
        SELECT
            tanks.fuel_type_id,
            DATE(tank_stocks.date) AS stock_date,
            SUM(tank_stocks.reading_in_ltr) AS daily_quantity,
            SUM(SUM(tank_stocks.reading_in_ltr)) OVER (PARTITION BY tanks.fuel_type_id ORDER BY DATE(tank_stocks.date)) AS cumulative_quantity
        FROM
            tank_stocks
        JOIN
            tanks ON tank_stocks.tank_id = tanks.id
        WHERE
            tanks.petrol_pump_id = ?
        GROUP BY
            tanks.fuel_type_id, stock_date
    ),
    dip_records AS (
        SELECT
            tanks.fuel_type_id,
            DATE(dip_records.date) AS dip_record_date,
            SUM(dip_records.reading_in_ltr) AS dip_quantity
        FROM
            dip_records
        JOIN
            tanks ON dip_records.tank_id = tanks.id
        WHERE
            tanks.petrol_pump_id = ?
        GROUP BY
            tanks.fuel_type_id, dip_record_date
    ),
    tank_transfers AS (
        SELECT
            t.fuel_type_id,
            DATE(tt.date) AS transfer_date,
            SUM(tt.quantity_ltr) AS quantity_ltr
        FROM
            tank_transfers tt
        JOIN
            tanks t ON tt.tank_id = t.id
        WHERE
            t.petrol_pump_id = ?
        GROUP BY
            t.fuel_type_id, transfer_date
    ),
    credit_balance AS (
        SELECT
            cc.date,
            SUM(DISTINCT cc.balance) AS total_credit
        FROM
            customers c
        LEFT JOIN
            customer_credits cc ON cc.customer_id = c.id AND cc.is_special = 0
        WHERE
            c.petrol_pump_id = ?
        GROUP BY
            cc.date
    ),
    wages AS (
        SELECT
            ee.date,
            COALESCE(SUM(DISTINCT ee.amount_received), 0) AS total_wage
        FROM
            employees e
        LEFT JOIN
            employee_wages ee ON ee.employee_id = e.id
        WHERE
            e.petrol_pump_id = ?
        GROUP BY
            ee.date
    )
    SELECT
        cr.date AS reading_date,
        " . implode(', ', $selectClauses) . ",
        dr.daily_expense,
        dr.tuck_shop_rent,
        dr.tuck_shop_earning,
        dr.service_station_earning,
        dr.service_station_rent,
        dr.tyre_shop_earning,
        dr.tyre_shop_rent,
        dr.lube_shop_earning,
        dr.lube_shop_rent,
        dr.pump_rent,
        COALESCE(ps.amount, 0) AS products_amount,
        COALESCE(ps.profit, 0) AS products_profit,
        COALESCE(ee.total_wage,0) AS total_wage,
        COALESCE(cc.total_credit,0) AS total_credit
    FROM
        calculated_readings cr
    LEFT JOIN
        daily_reports dr ON cr.date = dr.date AND dr.petrol_pump_id = ?
    LEFT JOIN
        product_sales ps ON ps.petrol_pump_id = ? AND ps.date = cr.date
    LEFT JOIN
        tank_stocks ts ON cr.date = ts.stock_date AND cr.fuel_type_id = ts.fuel_type_id
    LEFT JOIN
        dip_records ds ON cr.date = ds.dip_record_date AND cr.fuel_type_id = ds.fuel_type_id
    LEFT JOIN
        tank_transfers tt ON cr.date = tt.transfer_date AND cr.fuel_type_id = tt.fuel_type_id
    LEFT JOIN
        credit_balance cc ON cc.date = cr.date
    LEFT JOIN
        wages ee ON ee.date = cr.date
    GROUP BY
        cr.date, dr.daily_expense,
        dr.tuck_shop_rent, dr.tuck_shop_earning,
        dr.service_station_earning, dr.service_station_rent,
        dr.tyre_shop_earning, dr.tyre_shop_rent,
        dr.lube_shop_earning, dr.lube_shop_rent,
        dr.pump_rent, ps.amount, ps.profit,
        ee.total_wage,
        cc.total_credit
    ORDER BY
        cr.date;
    ";

        $bankDeposits = BankDeposit::select('date', DB::raw('COALESCE(SUM(bank_deposit), 0) as total_deposit'))
            ->where('pump_id', $pumpId)
            ->groupBy('date')
            ->pluck('total_deposit', 'date')
            ->toArray();

        $fuelPurchasesSummary = DB::table('fuel_purchases')
            ->select('fuel_type_id', 'purchase_date', DB::raw('SUM(quantity_ltr) AS total_purchased_quantity'))
            ->where('petrol_pump_id', $pumpId)
            ->groupBy('fuel_type_id', 'purchase_date')
            ->get()
            ->toArray();

        // Convert the result into a structured indexed array
        $fulePurchases = [];

        foreach ($fuelPurchasesSummary as $data) {
            $fulePurchases[$data->purchase_date][$data->fuel_type_id] = $data->total_purchased_quantity;
        }

        $reportData = DB::select($query, [
            $pumpId, $pumpId, $pumpId, $pumpId, $pumpId, $pumpId, $pumpId, $pumpId, $pumpId
        ]);

        #dd($reportData[0]->diesel_digital_sold);
        // Format the report data
        $formattedReport = $this->formatReportData($reportData, $fuelTypesWithTanks);

        return view('client_admin.pump.report', [
            'reportData' => $formattedReport,
            'fuelTypes' => $fuelTypesWithTanks,
            'pump_id' => $pumpId,
            'bankDeposits' => $bankDeposits,
            'fulePurchases' => $fulePurchases,
        ]);
    }

    private function formatReportData($reportData, $fuelTypesWithTanks)
    {
        return array_map(function ($row) use ($fuelTypesWithTanks) {
            $row = (array)$row;

            foreach ($fuelTypesWithTanks as $fuelType) {
                $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                $row["{$columnBase}_profit"] =
                    (($row["{$columnBase}_digital_sold"] - $row["{$columnBase}_transfer_quantity"]) * $row["{$columnBase}_price"]) -
                    (($row["{$columnBase}_digital_sold"] - $row["{$columnBase}_transfer_quantity"]) * $row["{$columnBase}_buying_price"]);
            }

            return $row;
        }, $reportData);
    }

    public function getTanksByFuelType(Request $request)
    {
        $fuel_type_id = $request->fuel_type_id;
        $petrolPumpId = $request->petrol_pump_id;

        $tanks = PetrolPump::find($petrolPumpId)->tanks()->whereHas('fuelType', function ($q) use ($fuel_type_id) {
            $q->where('id', $fuel_type_id);
        })->get();

        return response()->json(['success' => true, 'tanks' => $tanks]);
    }

    public function generatePdf(Request $request, $pump_id)
    {
        // Debugging the request inputs
        // dd($request->all());

        // Extract start and end dates from the request
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Find the petrol pump by its ID
        $pump = PetrolPump::find($pump_id);

        // Get the fuel types with their associated tanks
        $fuelTypesWithTanks = DB::table('fuel_types')
            ->select('fuel_types.name', 'fuel_types.id')
            ->join('tanks', 'fuel_types.id', '=', 'tanks.fuel_type_id')
            ->join('petrol_pumps', 'tanks.petrol_pump_id', '=', 'petrol_pumps.id')
            ->where('petrol_pumps.company_id', $this->company->id)
            ->distinct()
            ->get();

        $selectClauses = [];
        foreach ($fuelTypesWithTanks as $fuelType) {
            $fuelTypeName = $fuelType->name;
            $fuelTypeId = $fuelType->id;
            $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelTypeName));

            $selectClauses[] = "
            SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN ABS(cr.digital_sold_ltrs) ELSE 0 END) AS `{$columnBase}_digital_sold`,
            SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN ABS(cr.analog_sold_ltrs) ELSE 0 END) AS `{$columnBase}_analog_sold`,
            MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.selling_price ELSE 0 END) AS `{$columnBase}_price`,
            MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.buying_price_per_ltr ELSE NULL END) AS `{$columnBase}_buying_price`,
            MAX(CASE WHEN ts.fuel_type_id = $fuelTypeId THEN ts.cumulative_quantity ELSE 0 END) AS `{$columnBase}_stock_quantity`,
            MAX(CASE WHEN ds.fuel_type_id = $fuelTypeId THEN ds.dip_quantity ELSE 0 END) AS `{$columnBase}_dip_quantity`,
            MAX(CASE WHEN tt.fuel_type_id = $fuelTypeId THEN tt.quantity_ltr ELSE 0 END) AS `{$columnBase}_transfer_quantity`
        ";
        }
        $query = "";
        // Update the SQL query with the start_date and end_date
//        $query = "
//        WITH calculated_readings AS (
//        SELECT
//            nr.nozzle_id,
//            nr.date,
//            ft.id AS fuel_type_id,
//            nr.digital_reading - COALESCE(
//                LAG(nr.digital_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date),
//                 digital_reading
//            ) AS digital_sold_ltrs,
//            nr.analog_reading - COALESCE(
//                LAG(nr.analog_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date),
//                analog_reading
//            ) AS analog_sold_ltrs,
//            fr.selling_price,
//            (
//                SELECT fp.buying_price_per_ltr
//                FROM fuel_purchases fp
//                WHERE fp.fuel_type_id = ft.id
//                  AND fp.petrol_pump_id = ?
//                  AND fp.purchase_date <= nr.date
//                ORDER BY fp.purchase_date DESC
//                LIMIT 1
//            ) AS buying_price_per_ltr
//        FROM
//            nozzle_readings nr
//        JOIN
//            nozzles n ON nr.nozzle_id = n.id
//        JOIN
//            fuel_types ft ON n.fuel_type_id = ft.id
//        LEFT JOIN
//            fuel_prices fr ON fr.fuel_type_id = n.fuel_type_id
//            AND fr.petrol_pump_id = n.petrol_pump_id
//            AND fr.date = (
//                SELECT MAX(fp.date)
//                FROM fuel_prices fp
//                WHERE fp.fuel_type_id = fr.fuel_type_id
//                AND fp.petrol_pump_id = fr.petrol_pump_id
//                AND fp.date <= nr.date
//            )
//        WHERE
//            fr.petrol_pump_id = ?
//            AND nr.date BETWEEN ? AND ?  -- Filtering by start and end dates
//    ),
//    tank_stocks AS (
//        SELECT
//            tanks.fuel_type_id,
//            DATE(tank_stocks.date) AS stock_date,
//            SUM(tank_stocks.reading_in_ltr) AS daily_quantity,
//            SUM(SUM(tank_stocks.reading_in_ltr)) OVER (PARTITION BY tanks.fuel_type_id ORDER BY DATE(tank_stocks.date)) AS cumulative_quantity
//        FROM
//            tank_stocks
//        JOIN
//            tanks ON tank_stocks.tank_id = tanks.id
//        WHERE
//            tanks.petrol_pump_id = ?
//            AND tank_stocks.date BETWEEN ? AND ?  -- Filtering by start and end dates
//        GROUP BY
//            tanks.fuel_type_id, stock_date
//    ),
//    dip_records AS (
//        SELECT
//            tanks.fuel_type_id,
//            DATE(dip_records.date) AS dip_record_date,
//            SUM(dip_records.reading_in_ltr) AS dip_quantity
//        FROM
//            dip_records
//        JOIN
//            tanks ON dip_records.tank_id = tanks.id
//        WHERE
//            tanks.petrol_pump_id = ?
//            AND dip_records.date BETWEEN ? AND ?  -- Filtering by start and end dates
//        GROUP BY
//            tanks.fuel_type_id, dip_record_date
//    ),
//    tank_transfers AS (
//        SELECT
//            t.fuel_type_id,
//            DATE(tt.date) AS transfer_date,
//            SUM(tt.quantity_ltr) AS quantity_ltr
//        FROM
//            tank_transfers tt
//        JOIN
//            tanks t ON tt.tank_id = t.id
//        WHERE
//            t.petrol_pump_id = ?
//            AND tt.date BETWEEN ? AND ?  -- Filtering by start and end dates
//        GROUP BY
//            t.fuel_type_id, transfer_date
//    ),
//	    credit_balance AS (
//        SELECT
//            cc.date,
//            SUM(DISTINCT cc.balance) AS total_credit
//        FROM
//            customers c
//        LEFT JOIN
//            customer_credits cc ON cc.customer_id = c.id AND cc.is_special = 0
//        WHERE
//            c.petrol_pump_id = ?
//        GROUP BY
//            cc.date
//    ),
//    wages AS (
//        SELECT
//            ee.date,
//            COALESCE(SUM(DISTINCT ee.amount_received), 0) AS total_wage
//        FROM
//            employees e
//        LEFT JOIN
//            employee_wages ee ON ee.employee_id = e.id
//        WHERE
//            e.petrol_pump_id = ?
//        GROUP BY
//            ee.date
//    )
//    SELECT
//        cr.date AS reading_date,
//        " . implode(', ', $selectClauses) . ",
//        dr.daily_expense,
//        dr.pump_rent,
//        COALESCE(ps.amount, 0) AS products_amount,
//        COALESCE(ps.profit, 0) AS products_profit,
//        COALESCE(ee.total_wage,0) AS total_wage,
//        COALESCE(cc.total_credit,0) AS total_credit
//    FROM
//        calculated_readings cr
//    LEFT JOIN
//        daily_reports dr ON cr.date = dr.date AND dr.petrol_pump_id = ?
//    LEFT JOIN
//        product_sales ps ON ps.petrol_pump_id = ? AND ps.date = cr.date
//    LEFT JOIN
//        tank_stocks ts ON cr.date = ts.stock_date AND cr.fuel_type_id = ts.fuel_type_id
//    LEFT JOIN
//        dip_records ds ON cr.date = ds.dip_record_date AND cr.fuel_type_id = ds.fuel_type_id
//    LEFT JOIN
//        tank_transfers tt ON cr.date = tt.transfer_date AND cr.fuel_type_id = tt.fuel_type_id
//	LEFT JOIN
//        credit_balance cc ON cc.date = cr.date
//    LEFT JOIN
//        wages ee ON ee.date = cr.date
//    WHERE
//        cr.date BETWEEN ? AND ?  -- Filtering by start and end dates
//    GROUP BY
//        cr.date, dr.daily_expense, dr.pump_rent, ps.amount, ps.profit,
//        ee.total_wage,
//        cc.total_credit
//    ORDER BY
//        cr.date;
//    ";

        // Execute the query with the necessary parameters
        $reportData = DB::select($query, [
            $pump_id, // Fuel pump ID for multiple places
            $pump_id, // Petrol pump ID for the calculated readings
            $start_date, // Start date for filtering
            $end_date, // End date for filtering
            $pump_id, // Petrol pump ID for the tank stocks
            $start_date, // Start date for tank stocks
            $end_date, // End date for tank stocks
            $pump_id, // Petrol pump ID for dip records
            $start_date, // Start date for dip records
            $end_date, // End date for dip records
            $pump_id, // Petrol pump ID for tank transfers
            $start_date, // Start date for tank transfers
            $end_date, // End date for tank transfers
            $pump_id, // Petrol pump ID for daily reports
            $pump_id, // Petrol pump ID for product sales
            $pump_id, // Petrol pump ID for customer credits
            $pump_id, // Petrol pump ID for employee wages
            $start_date, // Start date for employee wages
            $end_date, // End date for employee wages
        ]);

        // Format the report data
        $formattedReport = $this->formatReportData($reportData, $fuelTypesWithTanks);

        // Generate and download the PDF
        $pdf = Pdf::loadView('pdfs.report-pdf', [
            'reportData' => $formattedReport,
            'fuelTypes' => $fuelTypesWithTanks,
            'pump_id' => $pump_id,
            'pump' => $pump
        ])->setPaper('a4', 'landscape')->setOption('dpi', 180);
        $filename = "{$pump->name}-" . now()->format('d-m-Y') . ".pdf";

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

    public function get_sales_history_pdf(Request $request, $id)
    {
        $pump = $request->pump;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // $pump = PetrolPump::where('id', $pump_id)->first();
        $orders = $pump->productSales()->whereBetween('date', [$start_date, $end_date])->get();

        $pdf = Pdf::loadView('pdfs.sales-history-pdf', [
            'orders' => $orders,
            'pump' => $pump,
        ]);

        $filename = "{$pump->name}-sales-" . now()->format('d-m-Y') . ".pdf";

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

    function get_expenses_pdf(Request $request, $pump_id)
    {

        $pump = PetrolPump::where('id', $pump_id)->first();
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $daily_reports = DB::table('daily_reports as dr')
            ->leftJoin('bank_deposits as bd', function ($join) {
                $join->on('dr.date', '=', 'bd.date')
                    ->on('dr.petrol_pump_id', '=', 'bd.pump_id');
            })
            ->select(
                'dr.date',
                'dr.daily_expense',
                'dr.pump_rent',
                'bd.expense_detail',
                'bd.account_number',
                DB::raw('SUM(bd.bank_deposit) as bank_deposit')
            )
            ->where('dr.petrol_pump_id', $pump_id)
            ->whereBetween('dr.date', [$start_date, $end_date]) // Apply date filter here
            ->groupBy('dr.date', 'dr.daily_expense', 'dr.pump_rent', 'bd.expense_detail', 'bd.account_number')
            ->union(
                DB::table('bank_deposits as bd')
                    ->leftJoin('daily_reports as dr', function ($join) {
                        $join->on('bd.date', '=', 'dr.date')
                            ->on('bd.pump_id', '=', 'dr.petrol_pump_id');
                    })
                    ->select(
                        'bd.date',
                        'dr.daily_expense',
                        'dr.pump_rent',
                        'bd.expense_detail',
                        'bd.account_number',
                        DB::raw('SUM(bd.bank_deposit) as bank_deposit')
                    )
                    ->where('bd.pump_id', $pump_id)
                    ->whereBetween('bd.date', [$start_date, $end_date])
                    ->groupBy('bd.date', 'dr.daily_expense', 'dr.pump_rent', 'bd.expense_detail', 'bd.account_number')
            )
            ->orderBy('date')
            ->get();

        // dd($daily_reports);
        $pdf = Pdf::loadView('pdfs.daily-report-pdf', [
            'daily_reports' => $daily_reports,
            'pump' => $pump,
            'report_type' => $request->report_type,
        ]);

        $filename = "{$pump->name}-report-" . now()->format('d-m-Y') . ".pdf";

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

    public function getAnalyticsProfitsData($pump, $start_date, $end_date)
    {

        // Get the fuel types with their associated tanks
        $fuelTypesWithTanks = DB::table('fuel_types')
            ->select('fuel_types.name', 'fuel_types.id')
            ->join('tanks', 'fuel_types.id', '=', 'tanks.fuel_type_id')
            ->join('petrol_pumps', 'tanks.petrol_pump_id', '=', 'petrol_pumps.id')
            ->where('petrol_pumps.company_id', $this->company->id)
            ->distinct()
            ->get();

        $selectClauses = [];
        $allTanks = [];
        foreach ($fuelTypesWithTanks as $fuelType) {
            $fuelTypeName = $fuelType->name;
            $fuelTypeId = $fuelType->id;
            $allTanks[$fuelTypeId] = $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelTypeName));

            $selectClauses[] = "
            SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN ABS(cr.digital_sold_ltrs) ELSE 0 END) AS `{$columnBase}_digital_sold`,
            SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN ABS(cr.analog_sold_ltrs) ELSE 0 END) AS `{$columnBase}_analog_sold`,
            MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.selling_price ELSE 0 END) AS `{$columnBase}_price`,
            MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.buying_price_per_ltr ELSE NULL END) AS `{$columnBase}_buying_price`,
            MAX(CASE WHEN ts.fuel_type_id = $fuelTypeId THEN ts.cumulative_quantity ELSE 0 END) AS `{$columnBase}_stock_quantity`,
            MAX(CASE WHEN ds.fuel_type_id = $fuelTypeId THEN ds.dip_quantity ELSE 0 END) AS `{$columnBase}_dip_quantity`,
            MAX(CASE WHEN tt.fuel_type_id = $fuelTypeId THEN tt.quantity_ltr ELSE 0 END) AS `{$columnBase}_transfer_quantity`
        ";
        }
        // Update the SQL query with the start_date and end_date
        $query = "
    WITH calculated_readings AS (
        SELECT
            nr.nozzle_id,
            nr.date,
            ft.id AS fuel_type_id,
            nr.digital_reading - COALESCE(
                LAG(nr.digital_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date),
                digital_reading
            ) AS digital_sold_ltrs,
            nr.analog_reading - COALESCE(
                LAG(nr.analog_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date),
                analog_reading
            ) AS analog_sold_ltrs,
            fr.selling_price,
            (
                SELECT fp.buying_price_per_ltr
                FROM fuel_purchases fp
                WHERE fp.fuel_type_id = ft.id
                  AND fp.petrol_pump_id = ?
                  AND fp.purchase_date <= nr.date
                ORDER BY fp.purchase_date DESC
                LIMIT 1
            ) AS buying_price_per_ltr
        FROM
            nozzle_readings nr
        JOIN
            nozzles n ON nr.nozzle_id = n.id
        JOIN
            fuel_types ft ON n.fuel_type_id = ft.id
        LEFT JOIN
            fuel_prices fr ON fr.fuel_type_id = n.fuel_type_id
            AND fr.petrol_pump_id = n.petrol_pump_id
            AND fr.date = (
                SELECT MAX(fp.date)
                FROM fuel_prices fp
                WHERE fp.fuel_type_id = fr.fuel_type_id
                AND fp.petrol_pump_id = fr.petrol_pump_id
                AND fp.date <= nr.date
            )
        WHERE
            fr.petrol_pump_id = ?
            AND nr.date BETWEEN ? AND ?  -- Filtering by start and end dates
    ),
    tank_stocks AS (
        SELECT
            tanks.fuel_type_id,
            DATE(tank_stocks.date) AS stock_date,
            SUM(tank_stocks.reading_in_ltr) AS daily_quantity,
            SUM(SUM(tank_stocks.reading_in_ltr)) OVER (PARTITION BY tanks.fuel_type_id ORDER BY DATE(tank_stocks.date)) AS cumulative_quantity
        FROM
            tank_stocks
        JOIN
            tanks ON tank_stocks.tank_id = tanks.id
        WHERE
            tanks.petrol_pump_id = ?
            AND tank_stocks.date BETWEEN ? AND ?  -- Filtering by start and end dates
        GROUP BY
            tanks.fuel_type_id, stock_date
    ),
    dip_records AS (
        SELECT
            tanks.fuel_type_id,
            DATE(dip_records.date) AS dip_record_date,
            SUM(dip_records.reading_in_ltr) AS dip_quantity
        FROM
            dip_records
        JOIN
            tanks ON dip_records.tank_id = tanks.id
        WHERE
            tanks.petrol_pump_id = ?
            AND dip_records.date BETWEEN ? AND ?  -- Filtering by start and end dates
        GROUP BY
            tanks.fuel_type_id, dip_record_date
    ),
    tank_transfers AS (
        SELECT
            t.fuel_type_id,
            DATE(tt.date) AS transfer_date,
            SUM(tt.quantity_ltr) AS quantity_ltr
        FROM
            tank_transfers tt
        JOIN
            tanks t ON tt.tank_id = t.id
        WHERE
            t.petrol_pump_id = ?
            AND tt.date BETWEEN ? AND ?  -- Filtering by start and end dates
        GROUP BY
            t.fuel_type_id, transfer_date
    ),
	    credit_balance AS (
        SELECT
            cc.date,
            SUM(DISTINCT cc.balance) AS total_credit
        FROM
            customers c
        LEFT JOIN
            customer_credits cc ON cc.customer_id = c.id AND cc.is_special = 0
        WHERE
            c.petrol_pump_id = ?
        GROUP BY
            cc.date
    ),
    wages AS (
        SELECT
            ee.date,
            COALESCE(SUM(DISTINCT ee.amount_received), 0) AS total_wage
        FROM
            employees e
        LEFT JOIN
            employee_wages ee ON ee.employee_id = e.id
        WHERE
            e.petrol_pump_id = ?
        GROUP BY
            ee.date
    )

    SELECT
        cr.date AS reading_date,
        " . implode(', ', $selectClauses) . ",
        dr.daily_expense,
        dr.pump_rent,
        COALESCE(ps.amount, 0) AS products_amount,
        COALESCE(ps.profit, 0) AS products_profit,
		COALESCE(ee.total_wage,0) AS total_wage,
        COALESCE(cc.total_credit,0) AS total_credit
    FROM
        calculated_readings cr
    LEFT JOIN
        daily_reports dr ON cr.date = dr.date AND dr.petrol_pump_id = ?
    LEFT JOIN
        product_sales ps ON ps.petrol_pump_id = ? AND ps.date = cr.date
    LEFT JOIN
        tank_stocks ts ON cr.date = ts.stock_date AND cr.fuel_type_id = ts.fuel_type_id
    LEFT JOIN
        dip_records ds ON cr.date = ds.dip_record_date AND cr.fuel_type_id = ds.fuel_type_id
    LEFT JOIN
        tank_transfers tt ON cr.date = tt.transfer_date AND cr.fuel_type_id = tt.fuel_type_id
    LEFT JOIN
        credit_balance cc ON cc.date = cr.date
    LEFT JOIN
        wages ee ON ee.date = cr.date
    WHERE
        cr.date BETWEEN ? AND ?  -- Filtering by start and end dates
    GROUP BY
        cr.date, dr.daily_expense, dr.pump_rent, ps.amount, ps.profit,ee.total_wage,
        cc.total_credit
    ORDER BY
        cr.date;
    "; #analytics query

        $pump_id = $pump->id;

        #because sql query not wqorking fine here as it add one day in date something like this.
        $start_date_org_carbon = Carbon::parse($start_date);
        $start_date = Carbon::parse($start_date)->subDay()->toDateString();

        // Execute the query with the necessary parameters
        $reportData = DB::select($query, [
            $pump_id, // Fuel pump ID for multiple places
            $pump_id, // Petrol pump ID for the calculated readings
            $start_date, // Start date for filtering
            $end_date, // End date for filtering
            $pump_id, // Petrol pump ID for the tank stocks
            $start_date, // Start date for tank stocks
            $end_date, // End date for tank stocks
            $pump_id, // Petrol pump ID for dip records
            $start_date, // Start date for dip records
            $end_date, // End date for dip records
            $pump_id, // Petrol pump ID for tank transfers
            $start_date, // Start date for tank transfers
            $end_date, // End date for tank transfers
            $pump_id, // Petrol pump ID for daily reports
            $pump_id, // Petrol pump ID for product sales
            $pump_id, // Petrol pump ID for customer credits
            $pump_id, // Petrol pump ID for employee wages
            $start_date, // Start date for employee wages
            $end_date, // End date for employee wages
        ]);

        #analytics query
        // Format the report data
        $data = $this->formatReportData($reportData, $fuelTypesWithTanks);

        $gainProfit = [];
        $totalSold = [];
        $finalGainProfit = [];

        $totalProfit = $totalProfitWithGain = 0;
        $lastvalue = [];
        $profitSums = [];
        $fuelGain = []; #

        $end_date_carbon = Carbon::parse($end_date);
        foreach ($data as $entry) {

            $check_date = Carbon::parse($entry['reading_date']);

            if (!$check_date->between($start_date_org_carbon, $end_date_carbon))
                continue;

            foreach ($entry as $key => $value) {
                if (str_ends_with($key, '_profit')) {
                    if (!isset($profitSums[$key])) {
                        $profitSums[$key] = 0;
                    }
                    $profitSums[$key] += $value;
                }
            }

            #if any change do it also in reports
            $fuelsProfit = 0;
            foreach ($allTanks as $index => $tank) {

                $dipComparison = DipComparison::where([
                    'report_date' => $entry['reading_date'],
                    'fuel_type_id' => $index, #if records wrong then this id need to make with tank OR with fules etc
                    'pump_id' => $pump_id,
                ])->first();

                $key = $tank . '_gain';

                $dipComparisonFinal = $dipComparison ? $dipComparison->final_dip : 0;

                $gainProfit[$tank] = ($entry["{$tank}_price"] * $dipComparisonFinal) + @$gainProfit[$tank];

                if (!isset($totalSold[$tank])) {
                    $totalSold[$tank] = 0; // Initialize if not already set
                }
                $totalSold[$tank] += ($entry["{$tank}_digital_sold"] - $entry["{$tank}_transfer_quantity"]);

                if (!isset($fuelGain[$key])) {
                    $fuelGain[$key] = $dipComparisonFinal;
                } else
                    $fuelGain[$key] += $dipComparisonFinal;

                #last dip ko next main use krny k liy, custom logic today.
                $lastvalue[$tank] = $entry["{$tank}_dip_quantity"];

                $profit = $entry["{$tank}_digital_sold"] * $entry["{$tank}_price"] - $entry["{$tank}_digital_sold"] * $entry["{$tank}_buying_price"];
                $fuelsProfit += $profit;

                $profitWithGain = $dipComparisonFinal * $entry["{$tank}_price"];

                $totalProfitWithGain += $profitWithGain;
            }

            #this one ok here.
            $totalProfit += $fuelsProfit + $entry['products_profit'] - $entry['pump_rent'] - $entry['daily_expense'] - $entry['total_wage'];
        }

        return [$profitSums, $fuelGain, $gainProfit, $totalProfit, $totalProfitWithGain, $totalSold];
    }
}


