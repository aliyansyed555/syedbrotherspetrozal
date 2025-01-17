@extends('layouts.app')

@section('main-content')

    <div class="mx-5 mt-5">
        <div class="card p-5 mb-5 d-flex">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h1>{{ $pump->name }}</h1>
                    <h3>{{ $pump->location }}</h3>
                </div>

                <div class="d-flex flex-wrap">
                    @foreach ($stocks as $stock )
                    <div class="border border-gray-300 rounded min-w-125px py-3 px-4 me-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="fs-2 fw-bolder" >{{ $stock['total_stock'] }}</div>
                        </div>
                        <div class="fw-bold fs-6 text-gray-700">{{ $stock['fuel_type_name'] }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex flex-wrap">
                    @foreach ($fuelPrices as $fuelType => $prices)
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="fs-2 fw-bolder" data-kt-countup-value="{{ $prices['selling_price'] }}" data-fuel-name="{{ $prices['fuel_type_name'] }}" id="fuel_price_{{ $prices['fuel_type_id']  }}" >Rs. {{ $prices['selling_price'] }}</div>
                        </div>
                        <div class="fw-bold fs-6 text-gray-700">{{ $prices['fuel_type_name'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div id="kt_content_container" class="mx-5">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid me-lg-5 order-2 order-lg-1 mb-10 mb-lg-0">
                <div class="card">
                    <div class="card-body">

                        <div class="stepper stepper-links d-flex flex-column" id="report_stepper">
                            <div class="stepper-nav pb-5">
                                <div class="stepper-item mx-2 current" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Readings</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Mobil Oil Sales</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Salaries</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Credits</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Card Transactions</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Tank Transfer</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Renting</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Other Expenses</h3>
                                </div>

                            </div>

                            <form class="form" novalidate="novalidate" id="report-stepper">
                                <div class="mb-5">
                                    @include('client_admin.pump.report-steps.readings')

                                    @include('client_admin.pump.report-steps.sales')

                                    @include('client_admin.pump.report-steps.wages')

                                    @include('client_admin.pump.report-steps.credits')

                                    @include('client_admin.pump.report-steps.cards')

                                    @include('client_admin.pump.report-steps.tank-transfer')

                                    @include('client_admin.pump.report-steps.renting')

                                    @include('client_admin.pump.report-steps.expenses')
                                </div>

                                <div class="separator separator mb-7"></div>

                                <div class="d-flex flex-stack">
                                    <div class="me-2">
                                        <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                            Back
                                        </button>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary" data-kt-stepper-action="submit">
                                            <span class="indicator-label">
                                                Submit
                                            </span>
                                            <span class="indicator-progress">
                                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>

                                        <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                            Continue
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="70px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Summary</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0 fs-6">
                        <div class="separator separator-dashed mb-7"></div>
                        <div class="mb-10">
                            <h5 class="mb-4">Reading Report</h5>
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2" id="sidebar_readings_table">
                                {{-- <tr>
                                    <td class="text-gray-400 p-1">Diesel Sold:</td>
                                    <td class="text-gray-800 p-1">00</td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Petrol Sold:</td>
                                    <td class="text-gray-800 p-1">00</td>
                                </tr> --}}
                            </table>
                        </div>
                        <div class="separator separator-dashed"></div>

                        <div class="mb-10">
                            <h5 class="mb-4">Daily Report</h5>
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                <tr>
                                    <td class="text-gray-400 p-1">Total Investment</td>
                                    <td class="text-gray-800 p-1">
                                        <!-- Form to edit and save the Total Investment -->
                                        <form action="{{ route('pump.updateInvestment', $pump->id) }}" method="POST" id="totalInvestmentForm">
                                            @csrf
                                            @method('PUT')
                                            <input
                                                style="max-width: 100px"
                                                type="number"
                                                name="total_investment"
                                                value="{{ $pump->total_investment }}"
                                                class="border p-1 rounded w-full"
                                                step="0.01"
                                            >
                                            <button type="submit" style="padding: 2px" class="btn btn-secondary btn-sm mt-2" title="Click to save investment">
                                               <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                     height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                          fill="black"></path>
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                          fill="black"></path>
                                                </svg>
                                            </span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Mobil Oil Sale</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_sale">00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Expenses:</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_expense">00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Credit:</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_credit">00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Received:</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_receive_from_customers">00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Cards Amount:</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_cards_amount">00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-gray-400 p-1">Bank Deposit:</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_bank_deposit">00</span></td>
                                </tr>


                                <tr id="sidebar_tuck_shop_rent" class="d-none">
                                    <td class="text-gray-400 p-1">Tuck Shop Rent:</td>
                                    <td class="text-gray-800 p-1"><span id="tuck_shop_rent_value">00</span></td>
                                </tr>

                                <tr id="sidebar_tuck_shop_earning" class="d-none">
                                    <td class="text-gray-400 p-1">Tuck Shop Earning:</td>
                                    <td class="text-gray-800 p-1"><span id="tuck_shop_earning_value">00</span></td>
                                </tr>

                                <tr id="sidebar_service_station_earning" class="d-none">
                                    <td class="text-gray-400 p-1">Service Station Earning:</td>
                                    <td class="text-gray-800 p-1"><span id="service_station_earning_value">00</span></td>
                                </tr>

                                <tr id="sidebar_service_station_rent" class="d-none">
                                    <td class="text-gray-400 p-1">Service Station Rent:</td>
                                    <td class="text-gray-800 p-1"><span id="service_station_rent_value">00</span></td>
                                </tr>

                                <tr id="sidebar_tyre_shop_earning" class="d-none">
                                    <td class="text-gray-400 p-1">Tyre Shop Earning:</td>
                                    <td class="text-gray-800 p-1"><span id="tyre_shop_earning_value">00</span></td>
                                </tr>

                                <tr id="sidebar_tyre_shop_rent" class="d-none">
                                    <td class="text-gray-400 p-1">Tyre Shop Rent:</td>
                                    <td class="text-gray-800 p-1"><span id="tyre_shop_rent_value">00</span></td>
                                </tr>

                                <tr id="sidebar_lube_shop_earning" class="d-none">
                                    <td class="text-gray-400 p-1">Lube Shop Earning:</td>
                                    <td class="text-gray-800 p-1"><span id="lube_shop_earning_value">00</span></td>
                                </tr>

                                <tr id="sidebar_lube_shop_rent" class="d-none">
                                    <td class="text-gray-400 p-1">Lube Shop Rent:</td>
                                    <td class="text-gray-800 p-1"><span id="lube_shop_rent_value">00</span></td>
                                </tr>

                                <tr>
                                    <td class="text-gray-400 p-1">Cash in Hand:</td>
                                    <td class="text-gray-800 p-1"><span id="sidebar_cash_in_hand">00</span></td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
<script>
    "use strict";
    var previousCashInHand = isNaN(parseFloat(@json($cashInHand))) ? 0 : parseFloat(@json($cashInHand));
    $('#sidebar_cash_in_hand').text(previousCashInHand);
    var pumpId = @json($pump_id);
</script>
<script src="{{ asset('assets/reporting.js') }}"></script>
@endsection
