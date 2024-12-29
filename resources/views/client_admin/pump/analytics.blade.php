@extends('layouts.app')

@section('main-content')
    <div class="mx-5 mt-5">

        <div class="card p-5 mb-5">
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
        </div>


        <div class="row">
            <div class="col-sm-3">
                <div class="card border">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Fuel Stock</h2>
                        <ul class="card-text list-unstyled">
                            @foreach ($stocks as $stock )
                                <li><strong>{{ $stock['fuel_type_name'] }}:</strong> {{ $stock['total_stock'] }}</li>
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
                            @foreach( $gain as $name => $profit )
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
                        <h2 class="card-title mb-4">Pump Expenses</h2>
                        <ul class="card-text list-unstyled">
                            @foreach( $dailyExpenses as $name => $value )
                                <li><strong>{{ ucwords(str_replace('_', ' ', $name)) }}:</strong> {{ round2Digit($value) }}</li>
                            @endforeach
                        </ul>
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
