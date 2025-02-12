@extends('layouts.app')

@section('main-content')
    <div class="mx-5 mt-5">
        <div class="card mb-5 mb-xl-8">

            <div class="card-header align-items-center border-0 pt-5">

                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="">
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                                {{ $account->person_name }} ({{ $account->bank_name }})
                            </a>
                        </div>
                        <div class="d-flex flex-wrap fw-bold fs-6 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                            fill="black"></path>
                                        <path
                                            d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                {{ $account->account_number  }}
                            </a>
                            <a href="#"
                                class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                <span class="svg-icon svg-icon-4 me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                            fill="black"></path>
                                        <path
                                            d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                {{ $account->account_type }}
                            </a>
                        </div>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-center align-items-center" data-kt-subscription-table-toolbar="base">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#creditModal">
                          Transfer Amount
                        </button>
                    </div>
                    <!--end::Toolbar-->

                </div>
                <!--end::Card toolbar-->
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="credits_table">
                        <thead>
                            <tr class="fw-bolder text-muted">

                                <th class="min-w-150px">Date</th>
                                <th class="min-w-150px">Amount</th>
                                <th class="min-w-150px">Type</th>
                                <th class="min-w-150px">Revise Account</th>
                                <th class="min-w-150px">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $balance = 0;
                            @endphp
                            @foreach ($credits as $credit)
                                <tr>
                                    <td>{{ $credit->date }}</td>
                                    <td>{{ $credit->amount }}</td>
                                    <td>{{ $credit->type }}</td>
                                    <td>{{ $credit->revise_account_id }} {+++}</td>
                                    <td>{{ $credit->remarks }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="creditModal" tabindex="-1" aria-labelledby="creditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="creditModalLabel">Transfer Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add_customer_credit') }}" method="POST">
                    @csrf
                <div class="modal-body">
                    <div class="row position-relative">
                        <input type="hidden" name="account_id" value=" {{$account->id}}">
                        <div class="col-md-6 mb-5">
                            <div class="fv-row">
                                <label class="required form-label" for="remarks">Date</label>
                                <input type="date" required class="form-control form-control-solid" placeholder="Date" id="date" name="date" />
                            </div>
                        </div>


                        <div class="col-md-6 mb-5">
                            <div class="fv-row">
                                <label class="required form-label" for="bill_amount">Account Too</label>
                                <input type="text" class="form-control form-control-solid" placeholder="00" id="bill_amount" name="bill_amount" />
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <div class="fv-row">
                                <label class="required form-label" for="amount_paid">Amount </label>
                                <input type="text" class="form-control form-control-solid" placeholder="00" id="amount_paid" name="amount_paid" />
                            </div>
                        </div>

                        
                        <div class="col-md-6 mb-5">
                            <div class="fv-row">
                                <label class="required form-label" for="remarks">Comment</label>
                                <input type="text" class="form-control form-control-solid" placeholder="Detail About Credit" id="remarks" name="remarks" />
                            </div>
                        </div>

                        <div class="col-md-12 mt-5">
                            <button type="submit" class="btn btn-primary" id="add_credit">Add Credit</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('javascript')
    <script>
        $(document).ready(function() {
            let startDate = null;
            let endDate = null;
            const customerId = {{ $account->id }};

            const datepicker = $("[name=daterange]");
            $(datepicker).flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                mode: "range"
            });

            // Custom filtering function for date range
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                // Column index of the date (adjust index based on your table)
                const dateColumnIndex = 1;
                const dateValue = data[dateColumnIndex]; // Get the date from the table row

                // Only filter if startDate or endDate is set
                if (startDate && endDate) {
                    return dateValue >= startDate && dateValue <= endDate;
                }
                return true;
            });

            $('#credits_table').DataTable({
                responsive: true,
                pageLength: 30,
                ordering: true,
                // footerCallback: function(row, data, start, end, display) {
                //     // Get DataTable API instance
                //     var api = this.api();

                //     // Calculate total for the Balance column (index 4)
                //     var totalBalance = api
                //         .column(4, {
                //             page: 'current'
                //         }) // Use current page data
                //         .data()
                //         .reduce(function(a, b) {
                //             // Convert string to number, handle comma separators, and NaN
                //             return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                //         }, 0);

                //     // Update the footer for Balance column
                //     console.log("Total Balance:", totalBalance); // Log the total
                //     $(api.column(4).footer()).html(totalBalance.toLocaleString(
                //     'en-US')); // Format with commas
                // }
            });


        });
    </script>
@endsection


@section('styles')
@endsection
