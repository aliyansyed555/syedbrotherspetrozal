@extends('layouts.app')

@section('styles')
    <style>
        .border {
            border: 5px solid #eff2f5 !important;
        }

        .card .card-body {
            padding: 0px !important;
        }

        .card {
            background: #ffffff; /* White background for contrast */
            border: 1px solid #e0e0e0; /* Light border for structure */
            border-radius: 15px; /* Smooth rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1),
            0 6px 20px rgba(0, 0, 0, 0.1); /* 3D shadow effect */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover transition */
            padding: 20px;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px); /* Lift the card slightly on hover */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2),
            0 20px 40px rgba(0, 0, 0, 0.15); /* Stronger shadow on hover */
        }

        .card h1 {
            font-size: 1.5rem; /* Slightly larger and bolder heading */
            font-weight: bold;
            color: #333; /* Dark gray for better readability */
        }

        .form-control {
            border: 1px solid #d0d0d0; /* Subtle border for input */
            border-radius: 10px; /* Rounded corners for input field */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff; /* Blue border on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Subtle focus shadow */
            outline: none; /* Remove default outline */
        }


         .total-sum {
             font-weight: bold; /* Make the text bold */
             font-size: 1.2rem; /* Adjust the font size */
             color: #28a745; /* Green color for the text */
             background-color: #f8f9fa; /* Light gray background */
             padding: 5px 10px; /* Add some padding around the text */
             border: 1px solid #ced4da; /* Add a border */
             border-radius: 5px; /* Make the edges rounded */
             display: inline-block; /* Ensure proper spacing and alignment */
         }
    </style>
@endsection
@section('main-content')
    <div class="mx-5 mt-5">

        <div class="card p-5 mb-5">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">
                    {{ $pump->name }} ({{ $pump->location }})
                </h1>
                <input
                    class="form-control form-control-solid w-25"
                    data-kt-docs-table-filter="search"
                    placeholder="Pick date range"
                    id="kt_daterangepicker" />
            </div>
        </div>

        <div class="card p-5 mb-5">
            <div class="d-flex justify-content-between align-items-center"><h3 class="mb-7">Profits</h3></div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Total Sold</h2>
                            <ul class="card-text list-unstyled">
                                @foreach( $totalSold as $name => $sold )
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($sold) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Fuel Profit</h2>
                            <ul class="card-text list-unstyled">
                                @foreach( $profits as $name => $profit )
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($profit) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Gain Profit</h2>
                            <ul class="card-text list-unstyled">
                                @foreach( $gainProfit as $name => $profit )
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($profit) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Rate Change Profit</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ round2Digit($sumLossGain) }}</li>
                                @foreach( $total_loss_gain as $obj)
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $obj->fuel_name)) }}:</strong> {{ round2Digit($obj->total_loss_gain) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-5 mb-5">
            <div class="d-flex justify-content-between align-items-center"><h3 class="mb-7">Stocks</h3></div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Fuel Stock</h2>
                            <ul class="card-text list-unstyled">
                                @foreach ($stocks as $stock )
                                    <li><strong>{{ $stock['tank_name'] }}:</strong> {{ $stock['total_reading_in_ltr'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Mobiloil Stock</h2>
                            <ul class="card-text list-unstyled">
                                @foreach ($products as $product )
                                    <li><strong>{{ $product->name }}({{$product->company}}):</strong> {{ $product->quantity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Pending Credit</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ $totalCredit }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Pending Debit</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ $totalDebit }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $sum = 0; @endphp
        <div class="card p-5 mb-5">
            <div class="d-flex justify-content-between align-items-center"><h3 class="mb-7">Expenses</h3></div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Pump Expenses</h2>
                            <ul class="card-text list-unstyled">
                                @foreach( $dailyExpenses as $name => $value )
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($value) }}</li>
                                    @php $sum += $value; @endphp
                                @endforeach
                            </ul>

                            <ul class="card-text list-unstyled">
                                <li><strong>Total Expense:</strong> {{ round2Digit($sum) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Total Arrivals</h2>
                            <ul class="card-text list-unstyled">
                                @foreach( $total_arrivals as $obj)
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $obj->fuel_type_name)) }}:</strong> {{ round2Digit($obj->total_quantity_ltr) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-5 mb-5">
            <div class="d-flex justify-content-between align-items-center"><h3 class="mb-7">Others</h3></div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Cash in Hand</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ $cashInhand }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Mobiloil Profit</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ round2Digit($mobilOilProfit) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Fuel Gain</h2>
                            <ul class="card-text list-unstyled">
                                @foreach( $fuelGain as $name => $profit )
                                    <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($profit) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Shops Earnings</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total Sum:</strong> {{ $shopEarnings->total_sum }}</li>
                                @foreach( $shopEarnings as $name => $value )
                                    @if($value && $name!= 'total_sum')
                                        <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($value) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Final Profit</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ round2Digit($final_profit) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Final Profit With Gain</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ round2Digit($final_profit_with_gain) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Total Stock Amount</h2>
                            <ul class="card-text list-unstyled">
                                @foreach ($stocks as $stock )
                                    @if(isset($fuelPurchasesPrices[$stock['fuel_type_id']]))
                                        <li><strong>{{ $stock['tank_name'] }}:</strong> {{ $stock['total_reading_in_ltr'] * $fuelPurchasesPrices[$stock['fuel_type_id']] }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Total Mobiloil Amount</h2>
                            <ul class="card-text list-unstyled">
                                @foreach ($products as $product )
                                    <li><strong>{{ $product->name }}({{$product->company}}):</strong> {{ $product->quantity*$product->buying_price }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                @php
                    $stocksArray = $stocks->toArray();
                    $productsArray = $products->toArray();
                    $totalStockAmount = array_sum(array_map(function($stock) use ($fuelPurchasesPrices) {
                        return isset($fuelPurchasesPrices[$stock['fuel_type_id']])
                            ? $stock['total_reading_in_ltr'] * $fuelPurchasesPrices[$stock['fuel_type_id']]
                            : 0;
                    }, $stocksArray));

                    $totalMobiloilAmount = array_sum(array_map(function($product) {
                        return $product['quantity'] * $product['buying_price'];
                    }, $productsArray));

                    $customValuesSum = ($totalStockAmount + $totalMobiloilAmount + $totalCredit) - $totalDebit;
                    $finalProfitCustom = $final_profit_with_gain > 0 ? $customValuesSum - $final_profit_with_gain : $customValuesSum + $final_profit_with_gain;
                    $fullyFinalProfitLoss = ($finalProfitCustom - $pump->total_investment) + $cashInhand;
                @endphp

                <div class="col-sm-3">
                    <div class="card border">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Fully Final Profit/Loss</h2>
                            <ul class="card-text list-unstyled">
                                <li><strong>Total:</strong> {{ round2Digit($fullyFinalProfitLoss) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection

@section('javascript')

    <script>

        $(document).ready(function() {
            // Function to get URL parameters
            function getParameterByName(name) {
                const url = window.location.href;
                name = name.replace(/[\[\]]/g, '\\$&');
                const regex = new RegExp(`[?&]${name}(=([^&#]*)|&|#|$)`);
                const results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }

            // Extract dates from URL or use today's date
            let startDate = getParameterByName('start_date') || moment().format('YYYY-MM-DD');
            let endDate = getParameterByName('end_date') || moment().format('YYYY-MM-DD');

            // Initialize date range picker
            $("#kt_daterangepicker").daterangepicker({
                startDate: startDate,
                endDate: endDate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                $("#daily_report_table").DataTable().draw();
            });

            // Submit separate start_date and end_date on change
            $('#kt_daterangepicker').on('apply.daterangepicker', function(ev, picker) {
                const newUrl = `${window.location.origin}${window.location.pathname}?start_date=${picker.startDate.format('YYYY-MM-DD')}&end_date=${picker.endDate.format('YYYY-MM-DD')}`;
                window.location.href = newUrl; // Reload the page with new parameters
            });
        });

    </script>
@endsection
