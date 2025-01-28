@extends('layouts.app')

@section('main-content')
    <div class="mx-5 mt-5">
        {{-- <a href="{{ route('pump.getPumpReportPdf', ['pump_id' => $pump_id]) }}" class="btn btn-primary">Download PDF</a> --}}
        <div class="card">
            <div class="card-header border-0 pt-5">

                <!--begin::Card title-->
                <div class="card-title">
                    <div class="d-flex align-items-center my-1">
                        <input class="form-control form-control-solid" data-kt-docs-table-filter="search"
                            placeholder="Pick date rage" id="kt_daterangepicker" />
                    </div>

                    <button
                        title="Click to refresh reports dip to the table to update records on analytics page"
                        type="button"
                        class="btn btn-light-danger me-3"
                        id="refresh-dip-button"
                        data-pump-id="33">
                        Refresh DIP
                    </button>

                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">

                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                            data-bs-target="#report_generation_form_modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                                        transform="rotate(90 12.75 4.25)" fill="black" />
                                    <path
                                        d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                        fill="black" />
                                    <path
                                        d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                        fill="#C4C4C4" />
                                </svg>
                            </span>
                            Export PDF
                        </button>
                        <!--end::Export-->
                        <!--begin::Add subscription-->

                    </div>
                    <!--end::Toolbar-->

                </div>
                <!--end::Card toolbar-->
            </div>
            <div class="card-body pt-0">
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

                                        // Calculate profit
                                        $profit = $digitalSold * $price - $digitalSold * $buyingPrice;
                                        $fuelsProfit += $profit;

                                        // Calculate dip comparison
                                        $lastDipQty = $i == 0 ? 0 : $reportData[$i - 1]["{$columnBase}_dip_quantity"];
                                        $dipComparisonFinal = $i == 0
                                            ? $dipQuantity - $stockQuantity
                                            : ($lastDipQty - $digitalSold - $dipQuantity) * -1;

                                        $dipComparisonFinal = round2Digit($dipComparisonFinal);

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
                                        {{ $reportData[$i]["{$columnBase}_digital_sold"] - $reportData[$i]["{$columnBase}_transfer_quantity"] }}
                                    </td>
                                    <td>{{ $reportData[$i]["{$columnBase}_price"] }}</td>
                                    <td>{{ round2Digit($reportData[$i]["{$columnBase}_profit"]) }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_stock_quantity"] }}</td>
                                    <td>{{ $reportData[$i]["{$columnBase}_transfer_quantity"] }}</td>
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
            </div>
        </div>
    </div>

    <!--begin::Modal - Adjust Balance-->
    <div class="modal fade" id="report_generation_form_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Export Subscriptions</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="report_generation_form_close" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="report_generation_form" class="form">
                        @csrf
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">Select Date Range:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="Pick a date" name="daterange" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-5">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                                name="format" class="form-select form-select-solid">
                                <option value="pdf" selected>PDF</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        {{-- <div class="text-center">
                            <button type="reset" id="report_generation_form_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" id="report_generation_form_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div> --}}
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="submit" id="report_generation_form_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>

                        <!--end::Actions-->
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Card-->
@endsection

@section('javascript')
    <script>

        let reportDataArray = [];
        function addData(tank_dip, tank_stock, previous_stock,final_dip,report_date,fuel_type_id) {
            reportDataArray.push({
                tank_dip, tank_stock, previous_stock,final_dip,report_date,fuel_type_id
            });
        }

        $(document).ready(function() {
            const pumpId = @json($pump_id);
            const datepicker = $("[name=daterange]");

            // Handle datepicker range -- For more info on flatpickr plugin, please visit: https://flatpickr.js.org/
            $(datepicker).flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                mode: "range"
            });

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


            $('#refresh-dip-button').on('click', function() {
                const button = $(this);
                if (reportDataArray.length === 0) {
                    alert("No data to save!");
                    return;
                }

                // Send an AJAX request to the Laravel controller
                $.ajax({
                    url: `/pump/${pumpId}/report-refresh-dip`,
                    type: "POST",
                    data: {
                        rows: reportDataArray,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success('Dips data saved successfully!');
                        reportDataArray = [];
                    },
                    complete: function() {
                        toastr.error('Something went wrong plz check with manager!');
                        button.prop('disabled', false);
                    }
                });
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
                // responsive: true,
                pageLength: 30,
                ordering: true,
                columnDefs: [{
                    // Apply the custom date format in the first column (Date)
                    targets: 0, // Assuming the date is in the first column
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Convert the date to DD/MM/YYYY format
                            return moment(data).format('DD/MM/YYYY');
                        }
                        return data;
                    }
                }],
                footerCallback: function(row, data, start, end, display) {
                    // Get DataTable API instance
                    var api = this.api();

                    var sumColumn = function(index) {
                        return api
                            .column(index, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                            }, 0);
                    };

                    // Calculate totals for the last 5 columns
                    var dieselDipCamp = sumColumn(-31);
                    var petrolDipCamp = sumColumn(-24);
                    var dipCamp = sumColumn(-17);
                    var totalExpense = sumColumn(-8);
                    var totalBankDeposit = sumColumn(-7);
                    var totalMobilOilSale = sumColumn(-6);
                    var totalMobilOilProfit = sumColumn(-5);
                    var totalCustomerCredit = sumColumn(-4);
                    var totalGrossProfit = sumColumn(-3);
                    var totalProfit = sumColumn(-2);
                    var totalProfitWithGain = sumColumn(-1);

                    // Update the footer
                    // $(api.column(-31).footer()).html(dieselDipCamp.toLocaleString('en-US'));
                    $(api.column(-24).footer()).html(petrolDipCamp.toLocaleString('en-US'));
                    $(api.column(-17).footer()).html(dipCamp.toLocaleString('en-US'));
                    $(api.column(-8).footer()).html(totalExpense.toLocaleString('en-US'));
                    $(api.column(-7).footer()).html(totalBankDeposit.toLocaleString('en-US'));
                    $(api.column(-6).footer()).html(totalMobilOilSale.toLocaleString('en-US'));
                    $(api.column(-5).footer()).html(totalMobilOilProfit.toLocaleString('en-US'));
                    $(api.column(-4).footer()).html(totalCustomerCredit.toLocaleString('en-US'));
                    $(api.column(-3).footer()).html(totalGrossProfit.toLocaleString('en-US'));
                    $(api.column(-2).footer()).html(totalProfit.toLocaleString('en-US'));
                    $(api.column(-1).footer()).html(totalProfitWithGain.toLocaleString('en-US'));
                }
            });

            $('#report_generation_form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const daterangeValues = $(datepicker).val().split(' to ');
                var start_date = daterangeValues[0].trim();
                var end_date = daterangeValues[1].trim();
                formData.append('start_date', start_date);
                formData.append('end_date', end_date);


                $.ajax({
                    url: `/pump/${pumpId}/reports/pdf`,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);

                        if (response.status === 'success') {
                            $('#report_generation_form_modal').modal('hide');
                            toastr.success(
                                'PDF generated successfully. The download will start shortly.'
                                );

                            const downloadLink = document.createElement('a');
                            downloadLink.href = response.file_url;
                            downloadLink.download = response.file_url.split('/')
                        .pop(); // Use the file name from URL
                            downloadLink
                        .click(); // This will prompt the user to download the file
                        }
                    }
                });
            });
        });
    </script>
@endsection
