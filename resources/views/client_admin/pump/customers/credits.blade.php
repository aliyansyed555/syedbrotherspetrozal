@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center mb-2">
                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                            {{ $customer->name }}
                        </a>
                    </div>
                    <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
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
                            {{ $customer->address }}
                        </a>
                        <a href="tel:{{ $customer->phone }}"
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
                            {{ $customer->phone }}
                        </a>
                    </div>
                </div>
                <div class="mb-0">
                    <input class="form-control form-control-solid" data-kt-docs-table-filter="search"
                        placeholder="Pick date rage" id="kt_daterangepicker" />
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="credits_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Date</th>
                                <th class="min-w-150px">Total Amount</th>
                                <th class="min-w-150px">Received Amount</th>
                                <th class="min-w-150px">Closing Balance</th>
                                <th class="min-w-150px">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $balance = 0;
                            @endphp
                            @foreach ($credits as $credit)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                data-kt-check="true" data-kt-check-target=".widget-9-check">
                                        </div>
                                    </td>
                                    <td>{{ $credit->date }}</td>
                                    <td>{{ $credit->bill_amount }}</td>
                                    <td>{{ $credit->amount_paid }}</td>
                                    @php
                                        $balance += $credit->bill_amount - $credit->amount_paid;
                                    @endphp
                                    <td>{{ $balance }}</td>
                                    <td>{{ $credit->remarks }}</td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fs-5 fw-bolder fst-italic">
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                $("#credits_table").DataTable().draw();
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
                footerCallback: function(row, data, start, end, display) {
                    // Get DataTable API instance
                    var api = this.api();

                    // Calculate total for the Balance column (index 4)
                    var totalBalance = api
                        .column(4, {
                            page: 'current'
                        }) // Use current page data
                        .data()
                        .reduce(function(a, b) {
                            // Convert string to number, handle comma separators, and NaN
                            return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                        }, 0);

                    // Update the footer for Balance column
                    console.log("Total Balance:", totalBalance); // Log the total
                    $(api.column(4).footer()).html(totalBalance.toLocaleString(
                    'en-US')); // Format with commas
                }
            });
        });
    </script>
@endsection


@section('styles')
@endsection
