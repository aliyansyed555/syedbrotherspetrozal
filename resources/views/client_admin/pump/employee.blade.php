@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Employees</span>
                </h3>

                <div class="card-toolbar" >
                    <a href="#" class="btn btn-sm btn-primary btn-active-primary new_modal" data-bs-toggle="modal"
                        data-bs-target="#employee_modal">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                </rect>
                            </svg>
                        </span>
                        Add Employee
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="employee_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-150px">Phone</th>
                                <th class="min-w-150px">Address</th>
                                <th class="min-w-150px">Total Salary</th>
                                <th class="min-w-150px">Remaining Salary</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <form action="" method="POST" id="employee_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="employee_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Employee</h5>

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
                            <label for="employee_date" class="form-label">Date</label>
                            <input type="date" class="form-control form-control-solid" id="employee_date" name="employee_date" />
                        </div>


                        <div class="fv-row mb-5">
                            <label for="name" class="required form-label">Customer Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Alex Jones" id="name" name="name" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control form-control-solid" placeholder="03xxxxxxxxx" id="phone" name="phone" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Address, 304. Floor 2 Lhr" id="address" name="address" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="total_salary" class="form-label">Total Salary</label>
                            <input type="number" class="form-control form-control-solid" placeholder="9999" id="total_salary" name="total_salary" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="advance_salary" class="form-label">Advance Salary</label>
                            <input type="number" class="form-control form-control-solid" placeholder="10000" id="advance_salary" name="advance_salary" />
                        </div>

                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="employee_submit">Save</button>
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
                    dt = $("#employee_table").DataTable({
                        responsive: true,
                        pageLength: 10,
                        searchDelay: 500,
                        processing: true,
                        searching: true,
                        dom: 'frtp', // Exclude 'i' to hide the "total records per page" text
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
                            url: `/pump/${pumpId}/employee/getAll`,
                        },
                        columns: [{
                                data: 'id'
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'phone'
                            },
                            {
                                data: 'address'
                            },
                            {
                                data: 'total_salary'
                            },
                            {
                                data: 'remaining_salary'
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
                                    return `<div class="d-flex justify-content-end flex-shrink-0">
                                            <a href="/pump/${pumpId}/employee/show/${row.id}" class="btn btn-sm btn-icon btn-bg-light me-1 btn-active-color-primary">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black"></rect>
                                                    <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit_btn" data-bs-toggle="modal" data-bs-target="#employee_modal" data-obj='${JSON.stringify(row)}'>
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
                                        </button></div>
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


            $('#employee_table').on('click', '.edit_btn', function() {
                const dataObj = JSON.parse($(this).attr('data-obj'));
                $('#id').val(dataObj.id);
                $('#name').val(dataObj.name);
                $('#phone').val(dataObj.phone);
                $('#address').val(dataObj.address);
                $('#total_salary').val(dataObj.total_salary);
            });

            let prefix = `pump/${pumpId}`
            handlingForms('employee', prefix);
            deleteFn('employee', prefix)
        });


    </script>
@endsection


@section('styles')
@endsection
