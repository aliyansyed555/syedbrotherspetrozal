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

                    <button style="margin-left: 12px"
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
                @include('client_admin.pump._reports_table')
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
{{--                        <div class="fv-row mb-10">--}}
{{--                            <!--begin::Label-->--}}
{{--                            <label class="fs-5 fw-bold form-label mb-5">Select Export Format:</label>--}}
{{--                            <!--end::Label-->--}}
{{--                            <!--begin::Input-->--}}
{{--                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"--}}
{{--                                name="format" class="form-select form-select-solid">--}}
{{--                                <option value="pdf" selected>PDF</option>--}}
{{--                            </select>--}}
{{--                            <!--end::Input-->--}}
{{--                        </div>--}}
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

        function addData(tank_dip, tank_stock, previous_stock, final_dip, report_date, fuel_type_id) {
            reportDataArray.push({
                tank_dip,
                tank_stock,
                previous_stock,
                final_dip,
                report_date,
                fuel_type_id
            });
        }

        $(document).ready(function () {
            const pumpId = @json($pump_id);
            const datepicker = $("[name=daterange]");

            // Initialize Datepicker
            $(datepicker).flatpickr({
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                mode: "range"
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
                        button.prop('disabled', false);
                    }
                });
            });

            let startDate = null;
            let endDate = null;

            $("#kt_daterangepicker").daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function (start, end) {
                startDate = start.format('DD/MM/YYYY');
                endDate = end.format('DD/MM/YYYY');
                console.log("Filtering dates:", startDate, endDate);
                $("#reports_table").DataTable().draw();
            });

            // Custom filter for DataTables to filter by selected date range
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                const dateColumnIndex = 0;
                const dateValue = data[dateColumnIndex]; // Assuming date is in the first column
                const rowDate = moment(dateValue, "DD/MM/YYYY", true);

                if (!rowDate.isValid()) {
                    return false;
                }

                if (startDate && endDate) {
                    const start = moment(startDate, "DD/MM/YYYY");
                    const end = moment(endDate, "DD/MM/YYYY");

                    return rowDate.isBetween(start, end, 'day', '[]'); // Includes start & end dates
                }

                return true; // Show all by default
            });

            const table = $('#reports_table').DataTable({
                pageLength: 30,
                ordering: true,
                columnDefs: [{
                    targets: 0, // Assuming the date is in the first column
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            return moment(data, "YYYY-MM-DD").format('DD/MM/YYYY');
                        }
                        return data;
                    }
                }],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    var sumColumn = function (index) {
                        return api
                            .column(index, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function (a, b) {
                                return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                            }, 0);
                    };

                    $(api.column(-24).footer()).html(sumColumn(-24).toLocaleString('en-US'));
                    $(api.column(-17).footer()).html(sumColumn(-17).toLocaleString('en-US'));
                    $(api.column(-8).footer()).html(sumColumn(-8).toLocaleString('en-US'));
                    $(api.column(-7).footer()).html(sumColumn(-7).toLocaleString('en-US'));
                    $(api.column(-6).footer()).html(sumColumn(-6).toLocaleString('en-US'));
                    $(api.column(-5).footer()).html(sumColumn(-5).toLocaleString('en-US'));
                    $(api.column(-4).footer()).html(sumColumn(-4).toLocaleString('en-US'));
                    $(api.column(-3).footer()).html(sumColumn(-3).toLocaleString('en-US'));
                    $(api.column(-2).footer()).html(sumColumn(-2).toLocaleString('en-US'));
                    $(api.column(-1).footer()).html(sumColumn(-1).toLocaleString('en-US'));
                }
            });

            $('#report_generation_form').submit(function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const daterangeValues = $(datepicker).val().split(' to ');
                var start_date = daterangeValues[0] ? daterangeValues[0].trim() : "";
                var end_date = daterangeValues[1] ? daterangeValues[1].trim() : "";

                formData.append('start_date', start_date);
                formData.append('end_date', end_date);

                $.ajax({
                    url: `/pump/${pumpId}/reports/pdf`,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#report_generation_form_modal').modal('hide');
                            toastr.success('PDF generated successfully. The download will start shortly.');

                            const downloadLink = document.createElement('a');
                            downloadLink.href = response.file_url;
                            downloadLink.download = response.file_url.split('/').pop();
                            downloadLink.click();
                        }
                    }
                });
            });
        });

    </script>
@endsection
