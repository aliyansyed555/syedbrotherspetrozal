@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        {{-- <h1>{{$pump->name}}</h1> --}}
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Dip Record</span>
                </h3>

                <div class="card-toolbar" >
                    <a href="#" class="btn btn-sm btn-light btn-active-primary new_modal" data-bs-toggle="modal"
                        data-bs-target="#dip_modal">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                </rect>
                            </svg>
                        </span>
                        Add Dip Record
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="dip_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Tank</th>
                                <th class="min-w-150px">Reading in MM</th>
                                <th class="min-w-150px">Reading in Litres</th>
                                <th class="min-w-150px">Date</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <form action="" method="POST" id="dip_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="dip_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add dip record</h5>

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
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">Date </span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Select a date."></i>
                            </label>
                            <input class="form-control form-control-solid date_picker" placeholder="Pick date" name="date" id="date"/>
                        </div>
                        <div class="fv-row mb-5">
                            <label for="reading_in_mm" class="required form-label">Reading in MM</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Reading in MM" id="reading_in_mm" name="reading_in_mm" />
                        </div>
                        <div class="fv-row mb-5">
                            <label for="reading_in_ltr" class="required form-label">Reading in Litres</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Reading in Litres" id="reading_in_ltr" name="reading_in_ltr" />
                        </div>
                        
                        <div class="fv-row mb-5">
                            <label class="d-flex align-items-center fs-5 fw-bold mb-3" for="tank_id">
                                <span class="required">Select Tank</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select Carefully"></i>
                            </label>
                            <select class="form-select form-select-solid" name="tank_id" id="tank_id" aria-label="Select example">
                                <option disabled selected value>Open this menu</option>
                                @foreach ($tanks as $tank)
                                    <option value="{{$tank->id}}">{{$tank->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="dip_submit">Save</button>
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
                    dt = $("#dip_table").DataTable({
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
                            url: `/pump/${pumpId}/dip/get_all`,
                            error: function(xhr, status, error) {
                                if (xhr.status === 404 && xhr.responseJSON && xhr.responseJSON.redirect_url) {
                                    // Redirect to the 404 page
                                    window.location.href = xhr.responseJSON.redirect_url;
                                } else {
                                    // Show a general error message if needed
                                    alert('An unexpected error occurred.');
                                }
                            }
                        },
                        columns: [{
                                data: 'id'
                            },
                            {
                                data: 'tank_name'
                            },
                            {
                                data: 'reading_in_mm'
                            },
                            {
                                data: 'reading_in_ltr'
                            },
                            {
                                data: 'date'
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
                                    return `<button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit_btn" data-bs-toggle="modal" data-bs-target="#dip_modal" data-obj='${JSON.stringify(row)}'>
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

            $('#dip_table').on('click', '.edit_btn', function (e) {
                e.preventDefault();
                
                const dataObj = JSON.parse($(this).attr('data-obj'));
                
                $('#id').val(dataObj.id);
                $('#reading_in_mm').val(dataObj.reading_in_mm);
                $('#reading_in_ltr').val(dataObj.reading_in_ltr);
                $('#date').val(dataObj.date);
                
                // $('#tank_id').val(dataObj.tank_id);
                const tankIid = dataObj.tank_id;
                const dropdown = $('#tank_id');

                const optionExists = dropdown.find(`option[value="${tankIid}"]`).length > 0;

                if (optionExists) {
                    dropdown.val(tankIid).trigger('change'); 
                } else {
                    console.error('The specified tankIid does not exist in the dropdown.');
                }
                // Show the modal
                $('#dip_modal').modal('show');
            });

            let prefix = `pump/${pumpId}`
            handlingForms('dip', prefix);
            deleteFn('dip', prefix)
        });
        

    </script>
@endsection


@section('styles')
@endsection