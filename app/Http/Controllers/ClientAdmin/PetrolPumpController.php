<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\PetrolPump;
use App\Models\NozzleReading;
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


    function get_expenses($pump_id)
    {

        $pump = PetrolPump::where('id', $pump_id)->first();
        $daily_reports = $pump->dailyReports()->get();

        $pump_id = $pump->id;

        return view('client_admin.pump.expenses', compact('daily_reports', 'pump_id'));

    }

    function save_bank_deposit(Request $request){
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

        DailyReport::create([
            'date' => $validatedData['date'],
            'bank_deposit' => -$validatedData['bank_deposit'],
            'account_number' => $validatedData['account_number'],
            'expense_detail' => $validatedData['expense_detail'],
            'petrol_pump_id' => $pump_id,
        ]);

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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ], [
            'name.required' => 'Name is required.',
            'location.required' => 'Email field is required.',
        ]);

        PetrolPump::create([
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'company_id' => $this->company->id,
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
        ];

        $petrol_pump->update($updateData);
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

                    DB::table('nozzle_readings')->insert([
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
                    DB::table('customer_credits')->insert([
                        'customer_id' => $credit['customer_id'],
                        'bill_amount' => $credit['bill_amount'],
                        'amount_paid' => $credit['amount_paid'],
                        'balance' => $credit['balance'],
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



            // 6. Save daily report
            DB::table('daily_reports')->insert([
                'daily_expense' => $request->input('daily_expense'),
                'expense_detail' => $request->input('expense_detail'),
                'pump_rent' => $request->input('pump_rent'),
                'bank_deposit' => $request->input('bank_deposit'),
                'cash_in_hand' => $request->input('cashInHand') ?? 0,
                'account_number' => $request->input('account_number'),
                'date' => $date,
                'petrol_pump_id' => $petrolPumpId,

                #new 4 options.
            ]);

            DB::commit(); // Commit the transaction

            return response()->json(['message' => 'Pumps data saved successfully!'], 200);

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
            ->distinct()
            ->get();

        $selectClauses = [];
        foreach ($fuelTypesWithTanks as $fuelType) {
            $fuelTypeName = $fuelType->name;
            $fuelTypeId = $fuelType->id;
            $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelTypeName));

            $selectClauses[] = "
                SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.digital_sold_ltrs ELSE 0 END) AS `{$columnBase}_digital_sold`,
                SUM(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.analog_sold_ltrs ELSE 0 END) AS `{$columnBase}_analog_sold`,
                MAX(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.selling_price ELSE 0 END) AS `{$columnBase}_price`,
                AVG(CASE WHEN cr.fuel_type_id = $fuelTypeId THEN cr.buying_price_per_ltr ELSE NULL END) AS `{$columnBase}_buying_price`,
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
                    LAG(nr.digital_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date),
                    0
                ) AS digital_sold_ltrs,
                nr.analog_reading - COALESCE(
                    LAG(nr.analog_reading) OVER (PARTITION BY nr.nozzle_id ORDER BY nr.date),
                    0
                ) AS analog_sold_ltrs,
                fr.selling_price,
                (
                    SELECT AVG(fp.buying_price_per_ltr)
                    FROM fuel_purchases fp
                    WHERE fp.fuel_type_id = ft.id
                    AND fp.petrol_pump_id = ?
                    AND fp.purchase_date <= nr.date
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
        )
        SELECT
            cr.date AS reading_date,
            " . implode(', ', $selectClauses) . ",
            dr.daily_expense,
            dr.pump_rent,
            dr.bank_deposit,
            COALESCE(ps.amount, 0) AS products_amount,
            COALESCE(ps.profit, 0) AS products_profit,
            COALESCE(SUM(DISTINCT ee.amount_received), 0) AS total_wage, -- Removed DISTINCT here to sum all wages
            SUM(DISTINCT cc.balance) AS total_credit
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
            customers c ON c.petrol_pump_id = ?
        LEFT JOIN
            customer_credits cc ON cc.customer_id = c.id AND cc.date = cr.date
        LEFT JOIN
            employees e ON e.petrol_pump_id = ?
        LEFT JOIN
            employee_wages ee ON ee.employee_id = e.id AND ee.date = cr.date
        GROUP BY
            cr.date, dr.daily_expense, dr.pump_rent, dr.bank_deposit, ps.amount, ps.profit
        ORDER BY
            cr.date;
        ";

        $reportData = DB::select($query, [
            $pumpId,
            $pumpId,
            $pumpId,
            $pumpId,
            $pumpId,
            $pumpId,
            $pumpId,
            $pumpId,
            $pumpId
        ]);

        // Format the report data
        $formattedReport = $this->formatReportData($reportData, $fuelTypesWithTanks);
        // return $formattedReport;

        return view('client_admin.pump.report', [
            'reportData' => $formattedReport,
            'fuelTypes' => $fuelTypesWithTanks
        ]);
    }




    private function formatReportData($reportData, $fuelTypesWithTanks)
    {
        return array_map(function ($row) use ($fuelTypesWithTanks) {
            $row = (array) $row;

            foreach ($fuelTypesWithTanks as $fuelType) {
                $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                $row["{$columnBase}_profit"] =
                    (($row["{$columnBase}_digital_sold"] - $row["{$columnBase}_transfer_quantity"]) * $row["{$columnBase}_price"]) -
                    (($row["{$columnBase}_digital_sold"]  - $row["{$columnBase}_transfer_quantity"]) * $row["{$columnBase}_buying_price"]);
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

}


