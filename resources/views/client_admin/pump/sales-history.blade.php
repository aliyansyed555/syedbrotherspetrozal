@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <div class="d-flex flex-column">
                    <!--begin::Export-->
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
                    <!--end::Export-->

                </div>
                <div class="mb-0">
                    <input class="form-control form-control-solid" data-kt-docs-table-filter="search"
                        placeholder="Pick date rage" id="kt_daterangepicker" />
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                        id="sales_history_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Id</th>
                                <th class="min-w-150px">Date</th>
                                <th class="min-w-150px">Amount</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                data-kt-check="true" data-kt-check-target=".widget-9-check">
                                        </div>
                                    </td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $order->amount }}</td>

                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light-success open_order_detail"
                                            data-bs-toggle="modal" data-bs-target="#order_modal"
                                            data-obj='{{ $order }}'>
                                            See Details
                                        </a>
                                    </td>
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
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="order_modal">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="card">
                    <div class="card-body p-lg-20">
                        <div class="d-flex flex-column flex-xl-row">
                            <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                                <div class="mt-n1">
                                    <div class="d-flex flex-stack pb-10">
                                        <a href="#">
                                            <img alt="Logo" src="{{ asset('assets/media/logos/logo-1.png') }}"
                                                style="width: 150px;" />
                                        </a>
                                        {{-- <a href="#" class="btn btn-sm btn-success">Pay Now</a> --}}
                                    </div>
                                    <div class="m-0">
                                        <div class="fw-bolder fs-3 text-gray-800 mb-8">Invoice #<span
                                                id="invoice-id"></span></div>
                                        <div class="row g-5 mb-11">
                                            <div class="col-sm-6">
                                                <div class="fw-bold fs-7 text-gray-600 mb-1">Issue Date:</div>
                                                <div class="fw-bolder fs-6 text-gray-800" id="invoice-date"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="table-responsive border-bottom mb-9">
                                                <table class="table mb-3">
                                                    <thead>
                                                        <tr class="border-bottom fs-6 fw-bolder text-muted">
                                                            <th class="min-w-175px pb-2">Description</th>
                                                            <th class="min-w-70px text-end pb-2">Qty</th>
                                                            <th class="min-w-80px text-end pb-2">Price</th>
                                                            <th class="min-w-100px text-end pb-2">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="product-details">
                                                        <!-- Dynamic rows will be inserted here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <div class="mw-300px">
                                                    <div class="d-flex flex-stack">
                                                        <div class="fw-bold pe-10 text-gray-600 fs-7">Total</div>
                                                        <div class="text-end fw-bolder fs-6 text-gray-800" id="total-amount"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <h2 class="fw-bolder">Export Sales History</h2>
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
            const url = new URL(window.location.href);
            const pumpId = url.pathname.split('/')[2];
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
                $("#sales_history_table").DataTable().draw();
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

            $('#sales_history_table').DataTable({
                responsive: false,
                pageLength: 30,
                ordering: true,
                footerCallback: function(row, data, start, end, display) {
                    // Get DataTable API instance
                    var api = this.api();


                    var totalAmount = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b.replace(/,/g, '') || 0);
                        }, 0);

                    // Update the footer
                    $(api.column(3).footer()).html(totalAmount.toLocaleString('en-US'));
                }
            });

            $(document).on('click', '.open_order_detail', function(e) {
                e.preventDefault();
                let orderData = $(this).data('obj');
                console.log(orderData);
                $('#invoice-id').text(orderData.id);
                $('#invoice-date').text(orderData.date);

                let totalAmount = 0;
                $('#total-amount').text(orderData.amount.toFixed(2));
                $('#product-details').empty();

                const products = JSON.parse(orderData.product_data);
                products.forEach(product => {
                    const productTotal = product.product_qty * product.product_price;
                    totalAmount += productTotal;
                    const productRow = `
                        <tr class="fw-bolder text-gray-700 fs-5 text-end">
                            <td class="d-flex align-items-center pt-6">${product.product_name}</td>
                            <td class="pt-6">${product.product_qty}</td>
                            <td class="pt-6">${product.product_price}</td>
                            <td class="fs-6 text-dark fw-boldest pt-6">${product.total}</td>
                        </tr>
                    `;
                    $('#product-details').append(productRow);
                });

                $('#total-amount').text(totalAmount.toFixed(2));
                // Show the modal
                $('#order_modal').modal('show');
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
                    url: `/pump/${pumpId}/sales-history-pdf` ,
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
