<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestAmirController extends Controller
{
    public function index2(){

        ini_set('max_execution_time', 300000); //300 seconds = 5 minutes
        ini_set('max_memory_limit', -1); //300 seconds = 5 minutes
        ini_set('memory_limit', '4096M');

       $nozzleIds = DB::table('nozzle_readings')->distinct()->pluck('nozzle_id');

       #if only for 1 pump check some stuff.
//       $pump = 71; #fuel_type_id = 1 for diesel
//       $nozzleIds = DB::table('nozzles')
//           ->where('petrol_pump_id' , $pump)
//           ->distinct()->pluck('id');

        foreach ($nozzleIds as $nozzleId) {
            $readings = DB::table('nozzle_readings')
                ->where('nozzle_id', $nozzleId)
                ->orderBy('date')
                ->orderBy('id')
                ->get(['id', 'date', 'digital_reading']);

            $dailySales = [];
            $previousReading = null;

            foreach ($readings as $reading) {
                $currentDate = $reading->date;
                $currentReading = $reading->digital_reading;

                if ($previousReading === null) {
                    // New condition: if first reading is less than 100, treat as sale
                    if ($currentReading < 100) {
                        $dailySales[$currentDate] = $currentReading;
                    }
                    $previousReading = $currentReading;
                    continue;
                }

                $sale = $currentReading - $previousReading;

                if ($sale < 0) {
                    $sale = abs($sale); // reset detected, treat as valid
                }

                if (!isset($dailySales[$currentDate])) {
                    $dailySales[$currentDate] = 0;
                }

                $dailySales[$currentDate] += $sale;
                $previousReading = $currentReading;
            }

            foreach ($dailySales as $date => $totalLitres) {
                DB::table('nozzle_reading_sales')->updateOrInsert(
                    [
                        'nozzle_id' => $nozzleId,
                        'sale_date' => $date,
                    ],
                    [
                        'total_litres' => $totalLitres,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        dd('done with final logic');
    }
}
