@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Products</span>
                </h3>

                <div class="card-toolbar" >
                    <a href="#" class="btn btn-sm btn-primary btn-active-primary new_modal" data-bs-toggle="modal"
                        data-bs-target="#product_modal">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                </rect>
                            </svg>
                        </span>
                        Add Product
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="product_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-150px">Company</th>
                                <th class="min-w-150px">Price</th>
                                <th class="min-w-150px">Buying Price</th>
                                <th class="min-w-150px">In Stock</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <form action="" method="POST" id="product_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="product_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Product</h5>

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
                        <input type="hidden" id="id" name="id" />
                        @csrf
                        
                        <div class="fv-row mb-5">
                            <label for="name" class="required form-label">Product</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Mobil" id="name" name="name" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Company" id="company" name="company" />
                        </div>

                        
                        <div class="fv-row mb-5">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control form-control-solid" placeholder="999" id="price" name="price" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="price" class="form-label">Buying Price</label>
                            <input type="text" class="form-control form-control-solid" placeholder="999" id="buying_price" name="buying_price" />
                        </div>

                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="product_submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="" method="POST" id="inventory_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="inventory_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Stock</h5>

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
                        <input type="hidden" id="product_id" name="product_id" />
                        
                        @csrf
                        
                        <div class="fv-row mb-5">
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">Date </span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Select a date."></i>
                            </label>
                            <input class="form-control form-control-solid date_picker" placeholder="Pick date" name="date" id="date"/>
                        </div>

                        <div class="fv-row mb-5">
                            <label for="quantity" class="required form-label">Quantity</label>
                            <input type="number" class="form-control form-control-solid" placeholder="Mobil" id="quantity" name="quantity" />
                        </div>

                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="inventory_submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('javascript')
    <script>
        $(document).ready(function() {
            // $("#fuel_type_table").DataTable();

            "use strict";

            var pumpId = @json($pump_id);
            // Class definition
            var KTDatatablesServerSide = function() {
                // Shared variables

                var table;
                var dt;

                // Private functions
                var initDatatable = function() {
                    dt = $("#product_table").DataTable({
                        responsive: true,
                        pageLength: 10,
                        searchDelay: 500,
                        processing: true,
                        // serverSide: true,
                        order: [
                            [1, 'asc']
                        ],
                        stateSave: false,
                        select: {
                            style: 'os',
                            selector: 'td:first-child',
                            className: 'row-selected'
                        },
                        ajax: {
                            url: `/pump/${pumpId}/product/getAll`,
                        },
                        columns: [{
                                data: 'id'
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'company'
                            },
                            {
                                data: 'price'
                            },
                            {
                                data: 'buying_price'
                            },
                            {
                                data: 'quantity'
                            },
                            {
                                data: null
                            },
                        ],
                        columnDefs: [{
                                targets: 0,
                                orderable: false,
                                render: function(data) {
                                    return `<div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>`;
                                }
                            },
                            {
                                targets: -1,
                                data: null,
                                orderable: false,
                                className: 'text-end',
                                render: function(data, type, row) {
                                    return `<button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 stock_btn" data-id='${row.id}'>
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M14.5 20.7259C14.6 21.2259 14.2 21.826 13.7 21.926C13.2 22.026 12.6 22.0259 12.1 22.0259C9.5 22.0259 6.9 21.0259 5 19.1259C1.4 15.5259 1.09998 9.72592 4.29998 5.82592L5.70001 7.22595C3.30001 10.3259 3.59999 14.8259 6.39999 17.7259C8.19999 19.5259 10.8 20.426 13.4 19.926C13.9 19.826 14.4 20.2259 14.5 20.7259ZM18.4 16.8259L19.8 18.2259C22.9 14.3259 22.7 8.52593 19 4.92593C16.7 2.62593 13.5 1.62594 10.3 2.12594C9.79998 2.22594 9.4 2.72595 9.5 3.22595C9.6 3.72595 10.1 4.12594 10.6 4.02594C13.1 3.62594 15.7 4.42595 17.6 6.22595C20.5 9.22595 20.7 13.7259 18.4 16.8259Z" fill="black"/>
                                                <path opacity="0.3" d="M2 3.62592H7C7.6 3.62592 8 4.02592 8 4.62592V9.62589L2 3.62592ZM16 14.4259V19.4259C16 20.0259 16.4 20.4259 17 20.4259H22L16 14.4259Z" fill="black"/>
                                                </svg>
                                            </span>
                                        </button>
                                        <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit_btn" data-bs-toggle="modal" data-bs-target="#product_modal" data-obj='${JSON.stringify(row)}'>
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
                                        <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete_btn" data-id='${row.id}'>
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                        fill="black"></path>
                                                    <path opacity="0.5"
                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                        fill="black"></path>
                                                    <path opacity="0.5"
                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                        fill="black"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    `;
                                },
                            },
                        ],
                        // Add data-filter attribute
                        createdRow: function(row, data, dataIndex) {
                            $(row).find('td:eq(1)').attr('data-filter', data.id);
                        }
                    });

                    table = dt.$;

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    dt.on('draw', function() {
                        KTMenu.createInstances();
                    });
                }

                return {
                    init: function() {
                        initDatatable();
                    }
                }
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KTDatatablesServerSide.init();
            });

            
            $('#product_table').on('click', '.edit_btn', function() {
                const dataObj = JSON.parse($(this).attr('data-obj'));
                $('#id').val(dataObj.id);
                $('#name').val(dataObj.name);
                $('#company').val(dataObj.company);
                $('#price').val(dataObj.price);
            });

            // data-bs-toggle="modal" data-bs-target="#inventory_modal" 
            var productId;
            $('#product_table').on('click', '.stock_btn', function(e) {
                e.preventDefault();

                productId = $(this).data('id');

                console.log("Getting product id: ", productId);
                
                $('#inventory_modal').modal('show');
            });

            $('#inventory_form').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                formData.append('product_id', productId);

                $.ajax({
                    url: `/pump/${pumpId}/product/addStock/${productId}`,
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Stock added successfully.');
                            $('#product_table').DataTable().ajax.reload();
                            $('#product_modal').modal('hide');
                        } else {
                            toastr.error('Failed to add stock. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An unexpected error occurred.');
                    }
                });
            });

            let prefix = `pump/${pumpId}`
            handlingForms('product', prefix);
            deleteFn('product', prefix)
        });
        

    </script>
@endsection


@section('styles')
@endsection
