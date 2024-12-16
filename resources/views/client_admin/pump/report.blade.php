@extends('layouts.app')

@section('main-content')
    <div class="mx-5 mt-5">
        <div class="card">
            <div class="card-header border-0 pt-5">
                <div class="d-flex flex-column">

                    <div class="d-flex align-items-center mb-2">
                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                            Reports
                        </a>
                    </div>

                </div>
                <div class="mb-0">
                    <input class="form-control form-control-solid" data-kt-docs-table-filter="search" placeholder="Pick date rage" id="kt_daterangepicker" />
                </div>
            </div>
            <div class="card-body">


                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="reports_table">
                    <thead>
                        <tr>
                            <th class="fw-bold">Date</th>
                            @foreach ($fuelTypes as $fuelType)
                                <th class="fw-bold">{{ $fuelType->name }} Sold</th>
                                <th class="fw-bold">{{ $fuelType->name }} Price</th>
                                <th class="fw-bold">{{ $fuelType->name }} Profit</th>
                                <th class="fw-bold">{{ $fuelType->name }} Stock</th>
                                <th class="fw-bold">{{ $fuelType->name }} TT</th>
                                <th class="fw-bold">{{ $fuelType->name }} Dip</th>
                                <th class="fw-bold">{{ $fuelType->name }} Dip Comparison</th>
                            @endforeach
                            
                            {{-- <th class="fw-bold">Salaries</th> --}}
                            <th class="fw-bold">Expense</th>
                            {{-- <th class="fw-bold">Pump Rent</th> --}}
                            <th class="fw-bold">Bank Deposit</th>
                            <th class="fw-bold">MobilOil Sale</th>
                            <th class="fw-bold">MobilOil Profit</th>
                            <th class="fw-bold">Customer Credit</th>
                            <th class="fw-bold">Gross Profit</th>
                            <th class="fw-bold">Total Profit</th>
                            <th class="fw-bold">Total Profit With Gain</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 0; $i < count($reportData); $i++)
                            <tr>
                                <td>{{ $reportData[$i]['reading_date'] }}</td>
                                @php
                                    
                                    $fuelsProfit = 0;
                                    $totalProfitWithGain = 0; 
                                    // $firstDipComparison = 0;
                                    $firstDipComparisons = [];
                                    foreach ($fuelTypes as $fuelType) {
                                        $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                                        $firstDipComparisons[$columnBase] = $i > 0 ? $reportData[$i - 1]["{$columnBase}_dip_quantity"] - $reportData[$i - 1]["{$columnBase}_stock_quantity"] : 0;
                                    } 

                                @endphp
                                @foreach ($fuelTypes as $fuelType)
                                    <?php 
                                        $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                                        $profit = $reportData[$i]["{$columnBase}_digital_sold"] * $reportData[$i]["{$columnBase}_price"] - $reportData[$i]["{$columnBase}_digital_sold"] * $reportData[$i]["{$columnBase}_buying_price"];
                                        $fuelsProfit += $profit; 

                                        $dipComparison = $reportData[$i]["{$columnBase}_dip_quantity"] - $reportData[$i]["{$columnBase}_stock_quantity"];
                                        $profitWithGain = $dipComparison * $reportData[$i]["{$columnBase}_price"];

                                        $totalProfitWithGain += $profitWithGain ;
                                    ?>
                                    <td>{{ $reportData[$i]["{$columnBase}_digital_sold"] - $reportData[$i]["{$columnBase}_transfer_quantity"] }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_price"] }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_profit"] }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_stock_quantity"] }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_transfer_quantity"] }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_dip_quantity"] }}</td>
                                    <td>
                                        <span class="py-2 px-3 {{ $dipComparison  >= 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $dipComparison - $firstDipComparisons[$columnBase] }}
                                        </span>
                                    </td>
                                @endforeach
                                
                                {{-- <td>{{ $reportData[$i]['total_wage'] }}</td> --}}
                                <td>{{ $reportData[$i]['pump_rent'] + $reportData[$i]['daily_expense'] + $reportData[$i]['total_wage'] }}</td>
                                {{-- <td>{{ $reportData[$i]['pump_rent']  }}</td> --}}
                                <td>{{ $reportData[$i]['bank_deposit'] }}</td>
                                <td>{{ $reportData[$i]['products_amount'] ?? '0.00' }}</td>
                                <td>{{ $reportData[$i]['products_profit'] ?? '0.00' }}</td>
                                <td>{{ $reportData[$i]['total_credit'] ?? '0.00' }}</td>
                                <td>
                                    <span class="py-2 px-3 {{ $fuelsProfit + $reportData[$i]['products_profit']  > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $fuelsProfit + $reportData[$i]['products_profit'] ?? '0.00' }}
                                    </span>
                                
                                </td>
                                <?php 
                                    $totalProfit = $fuelsProfit + $reportData[$i]['products_profit'] - $reportData[$i]['pump_rent'] - $reportData[$i]['daily_expense'] - $reportData[$i]['total_wage'] 
                                ?>
                                <td>
                                    <span class="py-2 px-3 {{ $totalProfit  > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $totalProfit  }}
                                    </span>
                                </td>
                                <td>
                                    <span class="py-2 px-3 {{ $totalProfitWithGain + $totalProfit  > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $totalProfitWithGain + $totalProfit }}
                                    </span>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            let startDate = null;
            let endDate = null;

            $("#kt_daterangepicker").daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {
                console.log(start, end);
                
                startDate = start.format('DD/MM/YYYY');
                endDate = end.format('DD/MM/YYYY');
                $("#reports_table").DataTable().draw();
            });

   
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
    
                const dateColumnIndex = 0;
                const dateValue = data[dateColumnIndex]; 

                
                if (startDate && endDate) {
                    return dateValue >= startDate && dateValue <= endDate;
                }
                return true;
            });

            $('#reports_table').DataTable({
                responsive: true,
                pageLength: 30,
                ordering: true,
                columnDefs: [
                    {
                        // Apply the custom date format in the first column (Date)
                        targets: 0, // Assuming the date is in the first column
                        render: function(data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                // Convert the date to DD/MM/YYYY format
                                return moment(data).format('DD/MM/YYYY');
                            }
                            return data;
                        }
                    }
                ]
            });
        });
    </script>
@endsection

@section('styles')
@endsection
{{-- [{"product_id":"9","product_name":"open oil","product_price":"1000","buying_price":"950","product_qty":"2","total":"2000"}] --}}