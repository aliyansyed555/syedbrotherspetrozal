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
                                    <h3 class="stepper-title fs-5">Other Expenses</h3>
                                </div>
                                <div class="stepper-item mx-2" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                    <h3 class="stepper-title fs-5">Renting</h3>
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

                                    @include('client_admin.pump.report-steps.expenses')

                                    @include('client_admin.pump.report-steps.renting')

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
                        <div class="separator separator-dashed mb-7"></div>

                        <div class="mb-10">
                            <h5 class="mb-4">Daily Report</h5>
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
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
