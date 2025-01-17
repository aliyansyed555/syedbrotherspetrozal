@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <div>
                    <input class="form-control form-control-solid" data-kt-docs-table-filter="search"
                        placeholder="Pick date rage" id="kt_daterangepicker" />
                </div>

                <div class="d-flex">
                    <!--begin::Export-->
                    <div>
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#report_generation_form_modal">
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
                    </div>
                    <!--end::Export-->
                    <div>
                        <a href="#" class="btn btn-primary new_modal" data-bs-toggle="modal"
                            data-bs-target="#daily_report_modal">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                    </rect>
                                </svg>
                            </span>
                            Transfer Amount
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="daily_report_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="min-w-150px">Date</th>
{{--                                <th class="min-w-150px">Daily Expense</th>--}}
{{--                                <th class="min-w-150px">Detail</th>--}}
{{--                                <th class="min-w-150px">Pump Rent</th>--}}
                                <th class="min-w-150px">Bank Deposit</th>
                                <th class="min-w-150px">Account Number</th>
                                {{-- <th class="min-w-100px text-end">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daily_reports as $daily_report)
                                <tr class="{{ $daily_report->bank_deposit < 0 ? 'bg-danger bg-opacity-10' : '' }}">

                                    <td>{{ $daily_report->date }}</td>
{{--                                    <td>{{ $daily_report->daily_expense }}</td>--}}
{{--                                    <td>{{ $daily_report->expense_detail }}</td>--}}
{{--                                    <td>{{ $daily_report->pump_rent }}</td>--}}
                                    <td>{{ $daily_report->bank_deposit }}</td>
                                    <td>{{ $daily_report->account_number }}</td>

                                    {{-- <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light-success">
                                            Edit
                                        </a>
                                    </td> --}}
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

    <form action="" method="POST" id="daily_report_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="daily_report_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Trasnfer Amount</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black"></rect>
                                </svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        {{-- <input type="hidden" id="id" name="id" /> --}}
                        @csrf

                        <div class="fv-row mb-5">
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">Date </span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Select a date."></i>
                            </label>
                            <input class="form-control form-control-solid date_picker" placeholder="Pick date" name="date" id="date"/>
                        </div>
                        <div class="fv-row mb-5">
                            <label for="bank_deposit" class="required form-label">Amount</label>
                            <input type="text" class="form-control form-control-solid" placeholder="00000" id="bank_deposit" name="bank_deposit" />
                        </div>
                        <div class="fv-row mb-5">
                            <label for="account_number" class="required form-label">Account Number</label>
                            <input type="text" class="form-control form-control-solid" placeholder="00000" id="account_number" name="account_number" />
                        </div>
                        <div class="fv-row mb-5">
                            <label for="expense_detail" class="required form-label">Details</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Details of Transfer" id="expense_detail" name="expense_detail" />
                        </div>

                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="nozzle_submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="report_generation_form_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bolder">Export Subscriptions</h2>
                    <div id="report_generation_form_close" data-bs-dismiss="modal"
                    aria-label="Close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="report_generation_form" class="form" >
                        @csrf
                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-5">Select Date Range:</label>
                            <input class="form-control form-control-solid" placeholder="Pick a date" name="daterange" />
                        </div>

                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-5">Deposit/Expenses</label>
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="report_type" class="form-select form-select-solid">
                                <option value="daily_report" selected>Report</option>
                                <option value="bank_transfer" >Bank Transfers</option>
                            </select>
                        </div>

                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-5">Select Export Format:</label>
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
                                <option value="pdf" selected>PDF</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" id="report_generation_form_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script>
        var pumpId = @json($pump_id);
        $(document).ready(function() {
            let startDate = null;
            let endDate = null;

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
                $("#daily_report_table").DataTable().draw();
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

            $('#daily_report_table').DataTable({
                responsive: false,
                pageLength: 50,
                ordering: true,
                order: [[ 0, "asc" ]],
                footerCallback: function(row, data, start, end, display) {
                    // Get DataTable API instance
                    var api = this.api();

                    var totalExpense = api
                        .column(1, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                        }, 0);

                    var totalRent = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                        }, 0);

                    var totalDeposit = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                        }, 0);

                    // Update the footer
                    $(api.column(1).footer()).html(totalExpense.toLocaleString('en-US'));
                    $(api.column(3).footer()).html(totalRent.toLocaleString('en-US'));
                    $(api.column(4).footer()).html(totalDeposit.toLocaleString('en-US'));
                }
            });

            $('#daily_report_form').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: `/pump/${pumpId}/daily-reports/create`,
                    type: 'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {

                            $('#card_transactions_modal').modal('hide');
                            toastr.success('Amount Transferred successfully.');

                            setTimeout(function() {
                                location.reload();
                            }, 1000);

                        }

                    },
                    error: function(data) {
                        var errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                // console.log(key + ': ' + value);
                                toastr.error(key + ': ' + value);
                            });
                        }
                    }
                });
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
                    url: `/pump/${pumpId}/get_expenses_pdf` ,
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
