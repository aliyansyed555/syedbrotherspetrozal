@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <div>
                    <input class="form-control form-control-solid" data-kt-docs-table-filter="search"
                        placeholder="Pick date rage" id="kt_daterangepicker" />
                </div>

                <div class="d-flex flex-column">
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
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="daily_report_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="min-w-150px">Date</th>
                                <th class="min-w-150px">Daily Expense</th>
                                <th class="min-w-150px">Detail</th>
                                <th class="min-w-150px">Pump Rent</th>
                                <th class="min-w-150px">Bank Deposit</th>
                                <th class="min-w-150px">Account Number</th>
                                {{-- <th class="min-w-100px text-end">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daily_reports as $daily_report)
                                <tr class="{{ $daily_report->bank_deposit < 0 ? 'bg-danger bg-opacity-10' : '' }}">
                                    
                                    <td>{{ $daily_report->date }}</td>
                                    <td>{{ $daily_report->daily_expense }}</td>
                                    <td>{{ $daily_report->expense_detail }}</td>
                                    <td>{{ $daily_report->pump_rent }}</td>
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
@endsection


@section('javascript')
    <script>
        var pumpId = @json($pump_id);
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


        });
    </script>
@endsection


@section('styles')
@endsection
