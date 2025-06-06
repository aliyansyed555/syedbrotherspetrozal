<?php

namespace App\Http\Controllers\ClientAdmin;

use App\Http\Controllers\ClientAdmin\Pump\NozzleController;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PetrolPumpController extends Controller{


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
        WITH latest_prices AS (
            SELECT fp.*
            FROM fuel_prices fp
            INNER JOIN (
                SELECT fuel_type_id, petrol_pump_id, MAX(date) AS max_date
                FROM fuel_prices
                GROUP BY fuel_type_id, petrol_pump_id
            ) latest ON fp.fuel_type_id = latest.fuel_type_id
                    AND fp.petrol_pump_id = latest.petrol_pump_id
                    AND fp.date = latest.max_date
        ),
        calculated_readings AS (
        SELECT
            nrs.nozzle_id,
            nrs.sale_date AS date,
            ft.id AS fuel_type_id,
            MAX(nrs.total_litres) AS digital_sold_ltrs,
            NULL AS analog_sold_ltrs, -- or remove if not needed
            (
                SELECT fp2.selling_price
                FROM fuel_prices fp2
                WHERE fp2.fuel_type_id = ft.id
                  AND fp2.petrol_pump_id = ?
                  AND fp2.date <= nrs.sale_date
                ORDER BY fp2.date DESC
                LIMIT 1
            ) AS selling_price,
            (
                SELECT fp.buying_price_per_ltr
                FROM fuel_purchases fp
                WHERE fp.fuel_type_id = ft.id
                  AND fp.petrol_pump_id = ?
                  AND fp.purchase_date <= nrs.sale_date
                ORDER BY fp.purchase_date DESC
                LIMIT 1
            ) AS buying_price_per_ltr
        FROM
            nozzle_reading_sales nrs
        JOIN
            nozzles n ON nrs.nozzle_id = n.id
        JOIN
            fuel_types ft ON n.fuel_type_id = ft.id
        WHERE
            n.petrol_pump_id = ?
            AND nrs.sale_date BETWEEN ? AND ?  -- Filtering by start and end dates
        GROUP BY
                nrs.nozzle_id, nrs.sale_date, ft.id
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
            GROUP BY t.fuel_type_id, transfer_date
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
            $totalProfit += $fuelsProfit + $entry['products_profit']; #- $entry['pump_rent'] - $entry['daily_expense'] - $entry['total_wage'] as here this one wrong value
        }

        return [$profitSums, $fuelGain, $gainProfit, $totalProfit, $totalProfitWithGain, $totalSold];
    }

}
