@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card">

            <div class="card-body">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-5">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black"></path>
                            </svg>
                        </span>
                        <input type="text" data-kt-docs-table-filter="search"
                            class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" />
                    </div>
                    <!--end::Search-->

                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                        <!--begin::Add customer-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#company_modal">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                        fill="black"></rect>
                                </svg>
                            </span>
                            Add Company
                        </button>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                        </div>

                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
                            Selection Action
                        </button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Datatable-->
                <table id="company_table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            {{-- <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#company_table .form-check-input" value="1" />
                                </div>
                            </th> --}}
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Created Date</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold">
                    </tbody>
                </table>
                <!--end::Datatable-->
            </div>
        </div>
    </div>



    <form action="" method="POST" id="company_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="company_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Company</h5>

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
                            <label for="" class="required form-label">Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Sean Bean"
                                id="name" name="name" />
                        </div>
                        <div class="fv-row card mb-5" id="test_id">
                            {{-- <label for="" class="required form-label">Select Admin</label>
                            <select class="form-select form-select-solid" name="user_id" id="user_id"
                                aria-label="Select example">
                            </select> --}}
                            <label for="" class="form-label">Select Admin</label>
                            <select class="form-select form-select-solid" name="user_id" id="user_id"
                                data-control="select2" data-placeholder="Select an option"
                                data-dropdown-parent="#test_id">
                                <option></option>
                            </select>
                        </div>
                        <div class="fv-row mb-5">
                            <label for="" class="form-label">Address</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Sean Bean"
                                name="address" id="address" />
                        </div>


                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="company_submit">Save</button>
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
                    dt = $("#company_table").DataTable({
                        responsive: true,
                        pageLength: 10,
                        select: {
                            style: 'os',
                            selector: 'td:first-child',
                            className: 'row-selected'
                        },
                        ajax: {
                            url: "/company/get_all_companies"
                        },
                        columns: [{
                                data: 'name',
                                title: 'Name'
                            },
                            {
                                data: 'address',
                                title: 'Address'
                            },
                            {
                                data: 'created_at',
                                render: function(data, type, row) {
                                    return moment(data).format('DD-MM-YYYY HH:mm');
                                }

                            },
                            {
                                data: null, // Actions column
                                orderable: false,
                                className: 'text-end',
                                render: function(data, type, row) {
                                    return `<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                        Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                                    </g>
                                                </svg>
                                        </span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 edit_btn" data-kt-docs-table-filter="edit_row" data-obj='${JSON.stringify(row)}'>
                                                Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3 delete_btn" data-kt-docs-table-filter="delete_row" data-id='${row.id}'>
                                                Delete
                                            </a>
                                        </div>
                                    </div>`;
                                }
                            }
                        ],
                        // Add data-filter attribute
                        createdRow: function(row, data, dataIndex) {
                            $(row).find('td:eq(0)').attr('data-id', data
                                .id); // Attach data-id attribute to the checkbox column
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

            $.ajax({
                url: '/company/get_available_admins',
                method: 'GET',
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        let dropdown = $('select[name="user_id"]'); // Target your select element
                        dropdown.empty(); // Clear any existing options

                        // Populate with new options
                        response.availableAdmins.forEach(function(admin) {
                            dropdown.append('<option></option>');
                            dropdown.append('<option value="' + admin.id + '">' + admin.name +
                                '</option>');
                        });
                    } else {
                        toastr.error('No available admins.');

                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KTDatatablesServerSide.init();
            });

            // var elem = 'clients';

            $('#company_table').on('click', '.edit_btn', function(e) {
                e.preventDefault();

                // Get the client data from the data-client attribute
                const dataObj = JSON.parse($(this).attr('data-obj'));
                console.log(dataObj);

                $('#id').val(dataObj.id); // Assuming you have a hidden field for client_id
                $('#name').val(dataObj.name);
                $('#address').val(dataObj.address);

                // $('#user_id').val(dataObj.user_id);
                const userId = dataObj.user_id;
                const dropdown = $('#user_id');

                const optionExists = dropdown.find(`option[value="${userId}"]`).length > 0;

                if (optionExists) {
                    dropdown.val(userId).trigger('change'); // Set the value and trigger change
                } else {
                    console.error('The specified user_id does not exist in the dropdown.');
                }
                // Call the modal function to open in edit mode with the full client object
                $('#company_modal').modal('show');
            });



            

            deleteFn('company');

            handlingForms('company');
        });
    </script>
@endsection


@section('styles')
@endsection
