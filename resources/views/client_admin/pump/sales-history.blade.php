@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <div class="d-flex flex-column">


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

        });
    </script>
@endsection


@section('styles')
@endsection
