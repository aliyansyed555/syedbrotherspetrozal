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
        <th class="fw-bold">Tuck Shop Rent</th>
        <th class="fw-bold">Tuck Shop Earning</th>
        <th class="fw-bold">Service Station Earning</th>
        <th class="fw-bold">Service Station Rent</th>
        <th class="fw-bold">Tyre Shop Earning</th>
        <th class="fw-bold">Tyre Shop Rent</th>
        <th class="fw-bold">Lube Shop Earning</th>
        <th class="fw-bold">Lube Shop Rent</th>

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
    @for ($i = 0; $i < count($reportData); $i++)
        <tr>
            <td>{{ $reportData[$i]['reading_date'] }}</td>
            @php

                $fuelsProfit = 0;
                $totalProfitWithGain = 0;
                // $firstDipComparison = 0;
                $firstDipComparisons = [];
                foreach ($fuelTypes as $fuelType) {
                    $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                    $firstDipComparisons[$columnBase] =
                        $i > 0
                            ? $reportData[$i - 1]["{$columnBase}_dip_quantity"] -
                                $reportData[$i - 1]["{$columnBase}_stock_quantity"]
                            : 0;

                }

            @endphp
            {{--                            //if any change do it also in Analytics code--}}
            @foreach ($fuelTypes as $fuelType)
                    <?php
                    // Define variables for repeated expressions
                    $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                    $digitalSold = $reportData[$i]["{$columnBase}_digital_sold"];
                    $price = $reportData[$i]["{$columnBase}_price"];
                    $buyingPrice = $reportData[$i]["{$columnBase}_buying_price"];
                    $dipQuantity = $reportData[$i]["{$columnBase}_dip_quantity"];
                    $stockQuantity = $reportData[$i]["{$columnBase}_stock_quantity"];
                    $readingDate = $reportData[$i]['reading_date'];
                    $tank_transfer_tt = $reportData[$i]["{$columnBase}_transfer_quantity"];

                    // Calculate profit
                    $profit = $digitalSold * $price - $digitalSold * $buyingPrice;
                    $fuelsProfit += $profit;

                    // Calculate dip comparison
                    $lastDipQty = $i == 0 ? 0 : $reportData[$i - 1]["{$columnBase}_dip_quantity"];
                    $dipComparisonFinal = $i == 0
                        ? $dipQuantity - $stockQuantity
                        : ($lastDipQty - $digitalSold - $dipQuantity) * -1;

                    if(isset($fulePurchases[$reportData[$i]['reading_date']][$fuelType->id]) && $i > 0)
                        $dipComparisonFinal = $dipComparisonFinal - $fulePurchases[$reportData[$i]['reading_date']][$fuelType->id];

                    $dipComparisonFinal = round2Digit($dipComparisonFinal) - $tank_transfer_tt; //New logic as shahnshah said.

                    // Calculate profit with gain
                    $profitWithGain = $dipComparisonFinal * $price;
                    $totalProfitWithGain += $profitWithGain;
                    ?>

                <script>
                    // Call the addData function with Blade variables
                    document.addEventListener('DOMContentLoaded', function () {
                        addData(
                            '{{ $dipQuantity }}',
                            '{{ $stockQuantity }}',
                            '{{ $lastDipQty }}',
                            '{{ $dipComparisonFinal }}',
                            '{{ $readingDate }}',
                            '{{ $fuelType->id }}'
                        );
                    });
                </script>

                <td>
                    {{ $reportData[$i]["{$columnBase}_digital_sold"] - $tank_transfer_tt }}
                </td>
                <td>{{ $reportData[$i]["{$columnBase}_price"] }}</td>
                <td>{{ round2Digit($reportData[$i]["{$columnBase}_profit"]) }}</td>
                <td>{{ $reportData[$i]["{$columnBase}_stock_quantity"] }}</td>
                <td>{{ $tank_transfer_tt }}</td>
                <td>{{ $reportData[$i]["{$columnBase}_dip_quantity"] }}</td>
                <td class="py-2 px-3 {{ $dipComparisonFinal >= 0 ? 'bg-success' : 'bg-danger' }}">
                    {{$dipComparisonFinal}}
                </td>
            @endforeach
            <td>{{ $reportData[$i]['tuck_shop_rent'] }}</td>
            <td>{{ $reportData[$i]['tuck_shop_earning'] }}</td>

            <td>{{ $reportData[$i]['service_station_earning'] }}</td>
            <td>{{ $reportData[$i]['service_station_rent'] }}</td>

            <td>{{ $reportData[$i]['tyre_shop_earning'] }}</td>
            <td>{{ $reportData[$i]['tyre_shop_rent'] }}</td>

            <td>{{ $reportData[$i]['lube_shop_earning'] }}</td>
            <td>{{ $reportData[$i]['lube_shop_rent'] }}</td>

            {{-- <td>{{ $reportData[$i]['total_wage'] }}</td> --}}
            <td>{{ $reportData[$i]['pump_rent'] + $reportData[$i]['daily_expense'] + $reportData[$i]['total_wage'] }}</td>
            {{-- <td>{{ $reportData[$i]['pump_rent']  }}</td> --}}
            <td>{{ @$bankDeposits[$reportData[$i]['reading_date']] }}</td>
            <td>{{ $reportData[$i]['products_amount'] ?? '0.00' }}</td>
            <td>{{ $reportData[$i]['products_profit'] ?? '0.00' }}</td>
            <td>{{ $reportData[$i]['total_credit'] ?? '0.00' }}</td>
            <td class="py-2 px-3 {{ $fuelsProfit + $reportData[$i]['products_profit'] > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ round(($fuelsProfit + $reportData[$i]['products_profit'] ?? '0.00') ,2) }}
            </td>
                <?php
                $totalProfit = $fuelsProfit + $reportData[$i]['products_profit'] - $reportData[$i]['pump_rent'] - $reportData[$i]['daily_expense'] - $reportData[$i]['total_wage'];
                ?>
            <td class="py-2 px-3 {{ $totalProfit > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ round($totalProfit , 2) }}
            </td>
            <td class="py-2 px-3 {{ $totalProfitWithGain + $totalProfit > 0 ? 'bg-success' : 'bg-danger' }}">
                {{round(($totalProfitWithGain + $totalProfit) , 2)}}
            </td>
        </tr>
    @endfor

    </tbody>
    <tfoot>
    <tr class="fs-5 fw-bolder fst-italic">
        <th class="fw-bold">Total:</th>
        @foreach ($fuelTypes as $fuelType)
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
            <th class="fw-bold"></th>
        @endforeach

        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
        <th class="fw-bold"></th>
    </tr>
    </tfoot>
</table>
