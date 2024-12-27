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
                                {{ $customer->name }}
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
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-center align-items-center" data-kt-subscription-table-toolbar="base">
                        <div class="me-3">
                            <input class="form-control form-control-solid" data-kt-docs-table-filter="search"
                            placeholder="Pick date rage" id="kt_daterangepicker" />

                        </div>
                        <!--begin::Export-->
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                            data-bs-target="#report_generation_form_modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
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
                        {{-- <tfoot>
                            <tr class="fs-5 fw-bolder fst-italic">
                                <th>Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
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
                    <div id="report_generation_form_close" data-bs-dismiss="modal"
                    aria-label="Close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
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
                    <form id="report_generation_form" class="form" >
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
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
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
        $(document).ready(function() {
            let startDate = null;
            let endDate = null;
            const pumpId = @json($pump_id);
            const customerId = {{ $customer->id }};

            const datepicker = $("[name=daterange]");
            $(datepicker).flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                mode: "range"
            }); 

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

            $('#report_generation_form').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const daterangeValues = $(datepicker).val().split(' to ');
                var start_date = daterangeValues[0].trim();
                var end_date = daterangeValues[1].trim();
                formData.append('start_date', start_date);
                formData.append('end_date', end_date);

                
                $.ajax({
                    url: `/pump/${pumpId}/customer/credits/generate_pdf/${customerId}` ,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        
                        if (response.status === 'success') {
                            $('#report_generation_form_modal').modal('hide');
                            toastr.success('PDF generated successfully. The download will start shortly.');

                            const downloadLink = document.createElement('a');
                            downloadLink.href = response.file_url;
                            downloadLink.download = response.file_url.split('/').pop(); // Use the file name from URL
                            downloadLink.click();// This will prompt the user to download the file
                        }
                    }
                });
            });


        });
    </script>
@endsection


@section('styles')
@endsection
