<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="reports_table">
    <thead>
    <tr>
        <th class="fw-bold">Date</th>
        @foreach ($fuelTypes as $fuelType)
            @php
                $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
            @endphp
            <th class="fw-bold">{{ $fuelType->name }} Sold</th>
            <th class="fw-bold">{{ $fuelType->name }} Price</th>
            <th class="fw-bold">{{ $fuelType->name }} Profit</th>
            <th class="fw-bold">{{ $fuelType->name }} Stock</th>
            <th class="fw-bold">{{ $fuelType->name }} TT</th>
            <th class="fw-bold">{{ $fuelType->name }} Dip</th>
            <th class="fw-bold">{{ $fuelType->name }} Dip Comparison</th>
        @endforeach

        <th class="fw-bold">Tuck Shop Rent</th>
        <th class="fw-bold">Tuck Shop Earning</th>
        <th class="fw-bold">Service Station Earning</th>
        <th class="fw-bold">Service Station Rent</th>
        <th class="fw-bold">Tyre Shop Earning</th>
        <th class="fw-bold">Tyre Shop Rent</th>
        <th class="fw-bold">Lube Shop Earning</th>
        <th class="fw-bold">Lube Shop Rent</th>
        <th class="fw-bold">Expense</th>
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
    @foreach ($reportData as $index => $data)
        <tr>
            <td>{{ $data['reading_date'] }}</td>
            @php
                $fuelsProfit = 0;
                $totalProfitWithGain = 0;
                 $readingDate = $data['reading_date'];
            @endphp

            @foreach ($fuelTypes as $fuelType)
                @php
                    $columnBase = strtolower(str_replace([' ', '-'], '_', $fuelType->name));
                    $digitalSold = $data["{$columnBase}_digital_sold"] ?? 0;
                    $price = $data["{$columnBase}_price"] ?? 0;
                    $buyingPrice = $data["{$columnBase}_buying_price"] ?? 0;
                    $dipQuantity = $data["{$columnBase}_dip_quantity"] ?? 0;
                    $stockQuantity = $data["{$columnBase}_stock_quantity"] ?? 0;
                    $tankTransferTT = $data["{$columnBase}_transfer_quantity"] ?? 0;

                    // Profit Calculation
                    $profit = ($digitalSold * $price) - ($digitalSold * $buyingPrice);
                    $fuelsProfit += $profit;

                    // Dip Comparison Calculation
                    $lastDipQty = $index > 0 ? $reportData[$index - 1]["{$columnBase}_dip_quantity"] : 0;
                    $dipComparisonFinal = $index == 0
                        ? ($dipQuantity - $stockQuantity)
                        : ($lastDipQty - $digitalSold - $dipQuantity) * -1;

                    if (isset($fuelPurchases[$data['reading_date']][$fuelType->id]) && $index > 0) {
                        $dipComparisonFinal -= $fuelPurchases[$data['reading_date']][$fuelType->id];
                    }

                    $dipComparisonFinal = round($dipComparisonFinal, 2) - $tankTransferTT;

                    // Profit with Gain
                    $profitWithGain = $dipComparisonFinal * $price;
                    $totalProfitWithGain += $profitWithGain;
                @endphp

{{--                <script>--}}
{{--                    // Call the addData function with Blade variables--}}
{{--                    document.addEventListener('DOMContentLoaded', function () {--}}
{{--                        addData(--}}
{{--                            '{{ $dipQuantity }}',--}}
{{--                            '{{ $stockQuantity }}',--}}
{{--                            '{{ $lastDipQty }}',--}}
{{--                            '{{ $dipComparisonFinal }}',--}}
{{--                            '{{ $readingDate }}',--}}
{{--                            '{{ $fuelType->id }}'--}}
{{--                        );--}}
{{--                    });--}}
{{--                </script>--}}

                <td>{{ $digitalSold - $tankTransferTT }}</td>
                <td>{{ number_format($price, 2) }}</td>
                <td>{{ number_format($profit, 2) }}</td>
                <td>{{ number_format($stockQuantity, 2) }}</td>
                <td>{{ number_format($tankTransferTT, 2) }}</td>
                <td>{{ number_format($dipQuantity, 2) }}</td>
                <td class="py-2 px-3 {{ $dipComparisonFinal >= 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ number_format($dipComparisonFinal, 2) }}
                </td>
            @endforeach

            <td>{{ number_format($data['tuck_shop_rent'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['tuck_shop_earning'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['service_station_earning'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['service_station_rent'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['tyre_shop_earning'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['tyre_shop_rent'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['lube_shop_earning'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['lube_shop_rent'] ?? 0, 2) }}</td>

            @php
                $expense = ($data['pump_rent'] ?? 0) + ($data['daily_expense'] ?? 0) + ($data['total_wage'] ?? 0);
                $totalProfit = $fuelsProfit + ($data['products_profit'] ?? 0) - $expense;
                $totalProfitWithGain += $totalProfit;
            @endphp

            <td>{{ number_format($expense, 2) }}</td>
            <td>{{ number_format($bankDeposits[$data['reading_date']] ?? 0, 2) }}</td>
            <td>{{ number_format($data['products_amount'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['products_profit'] ?? 0, 2) }}</td>
            <td>{{ number_format($data['total_credit'] ?? 0, 2) }}</td>
            <td class="py-2 px-3 {{ $fuelsProfit + ($data['products_profit'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ number_format($fuelsProfit + ($data['products_profit'] ?? 0), 2) }}
            </td>
            <td class="py-2 px-3 {{ $totalProfit > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ number_format($totalProfit, 2) }}
            </td>
            <td class="py-2 px-3 {{ $totalProfitWithGain > 0 ? 'bg-success' : 'bg-danger' }}">
                {{ number_format($totalProfitWithGain, 2) }}
            </td>
        </tr>
    @endforeach
    </tbody>

    @if(!isset($is_pdf))
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
     @endif
</table>
