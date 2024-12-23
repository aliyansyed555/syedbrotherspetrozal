<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 0px 3px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .bg-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .bg-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>{{ $pump->name }} - {{ $pump->location }}</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                @foreach ($fuelTypes as $fuelType)
                    <th>{{ $fuelType->name }} Sold</th>
                    <th>{{ $fuelType->name }} Price</th>
                    <th>{{ $fuelType->name }} Profit</th>
                    <th>{{ $fuelType->name }} Stock</th>
                    <th>{{ $fuelType->name }} TT</th>
                    <th>{{ $fuelType->name }} Dip</th>
                    <th>{{ $fuelType->name }} Dip Comparison</th>
                @endforeach
                
                {{-- <th>Salaries</th> --}}
                <th>Expense</th>
                {{-- <th>Pump Rent</th> --}}
                <th>Bank Deposit</th>
                <th>MobilOil Sale</th>
                <th>MobilOil Profit</th>
                <th>Customer Credit</th>
                <th>Gross Profit</th>
                <th>Total Profit</th>
                <th>Total Profit With Gain</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($reportData); $i++)
                <tr>
                    <td>{{ date('d_m_Y', strtotime($reportData[$i]['reading_date'])) }}</td>
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
                        <td>{{ number_format($reportData[$i]["{$columnBase}_profit"], 2) }}</td>
                        <td>{{ $reportData[$i]["{$columnBase}_stock_quantity"] }}</td>
                        <td>{{ $reportData[$i]["{$columnBase}_transfer_quantity"] }}</td>
                        <td>{{ number_format($reportData[$i]["{$columnBase}_dip_quantity"], 2) }}</td>
                        <td class="{{ $dipComparison  >= 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ number_format($dipComparison - $firstDipComparisons[$columnBase], 2) }}
                        </td>
                    @endforeach
                    
                    {{-- <td>{{ $reportData[$i]['total_wage'] }}</td> --}}
                    <td>{{ $reportData[$i]['pump_rent'] + $reportData[$i]['daily_expense'] + $reportData[$i]['total_wage'] }}</td>
                    {{-- <td>{{ $reportData[$i]['pump_rent']  }}</td> --}}
                    <td>{{ $reportData[$i]['bank_deposit'] }}</td>
                    <td>{{ $reportData[$i]['products_amount'] ?? '0.00' }}</td>
                    <td>{{ $reportData[$i]['products_profit'] ?? '0.00' }}</td>
                    <td>{{ $reportData[$i]['total_credit'] ?? '0.00' }}</td>
                    <td class="{{ $fuelsProfit + $reportData[$i]['products_profit']  > 0 ? 'bg-success' : 'bg-danger' }}">
                        
                        {{ number_format($fuelsProfit + $reportData[$i]['products_profit'], 2) }}
                       
                    
                    </td>
                    <?php 
                        $totalProfit = $fuelsProfit + $reportData[$i]['products_profit'] - $reportData[$i]['pump_rent'] - $reportData[$i]['daily_expense'] - $reportData[$i]['total_wage'] 
                    ?>
                    <td class="{{ $totalProfit  > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ number_format($totalProfit, 2) }}
                    </td>
                    <td class="{{ $totalProfitWithGain + $totalProfit  > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ number_format($totalProfitWithGain + $totalProfit, 2) }}
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
