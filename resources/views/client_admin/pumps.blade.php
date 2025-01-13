@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card">

            <div class="card-body">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-5">
                    <div class="d-flex align-items-center position-relative my-1">
                        <h4>Petrol Pumps</h4>
                        {{-- <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Pump" /> --}}
                    </div>

                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                        <!--begin::Add customer-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pump_modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Add Petrol Pump
                        </button>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Selection
                            Action</button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Wrapper-->

                <table id="pump_table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#pump_table .form-check-input" value="-1" />
                                </div>
                            </th>
                            <th>Name</th>
                            <th>Location</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold"></tbody>
                </table>
                <!--end::Datatable-->
            </div>
        </div>
    </div>

    <form action="" method="POST" id="pump_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="pump_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Pump</h5>

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
                            <label for="created_date" class="form-label">Created Date</label>
                            <input type="date" class="form-control form-control-solid" id="created_date" name="created_date" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="" class="required form-label">Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Pump Name Here"
                                id="name" name="name" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="location" class="required form-label">Location</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Lahore, PK"
                                id="location" name="location" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="cash_in_hand" class="required form-label">Cash inHand</label>
                            <input type="number" class="form-control form-control-solid" placeholder="99999" id="cash_in_hand" name="cash_in_hand" />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="total_investment" class="required form-label">Total Investment</label>
                            <input type="number" class="form-control form-control-solid" placeholder="99999" id="total_investment" name="total_investment" />
                        </div>



                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="pump_submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('javascript')
    <script>
        $(document).ready(function() {
            // Init Datatable
            "use strict";

            // Class definition
            var KTDatatablesServerSide = function() {
                // Shared variables

                var table;
                var dt;

                // Private functions
                var initDatatable = function() {
                    dt = $("#pump_table").DataTable({
                        responsive: true,
                        pageLength: 20,
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
                            url: "/pump/get_all",
                        },
                        columns: [
                            {
                                data: 'id'
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'location'
                            },
                            {
                                data: null
                            },
                        ],
                        columnDefs: [
                            {
                                targets: 0,
                                orderable: false,
                                render: function(data) {
                                    return `<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="${data}" />
                                </div>`;
                                }
                            },
                            {
                                targets: 1,
                                orderable: true,
                                render: function(data,type,row) {
                                    return `<a href="#" class="text-bold ">${row.name}</a>`;
                                }
                            },
                            {
                                targets: -1,
                                data: null,
                                orderable: false,
                                className: 'text-end',
                                render: function(data, type, row) {
                                    // let id = btoa(row.id);
                                    return `<a href="/pump/${row.id}/report" class="btn btn-sm btn-primary">Reports</a>
                                    <a href="/pump/${row.id}" class="btn btn-sm btn-icon btn-bg-light me-1 btn-active-color-primary">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black"></rect>
                                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit_btn" data-obj='${JSON.stringify(row)}'>
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
                            $(row).find('td:eq(3)').attr('data-filter', data.id);
                        }
                    });

                    table = dt.$;

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    dt.on('draw', function() {
                        // initToggleToolbar();
                        // toggleToolbars();
                        // handleDeleteRows();
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

            $('#pump_table').on('click', '.edit_btn', function(e) {
                e.preventDefault();
                const dataObj = JSON.parse($(this).attr('data-obj'));
                $('#id').val(dataObj.id); // Assuming you have a hidden field for client_id
                $('#name').val(dataObj.name);
                $('#location').val(dataObj.location);

                $('#pump_modal').modal('show');
            });

            deleteFn('pump');
            handlingForms('pump');
        });
    </script>
@endsection


@section('styles')
@endsection
