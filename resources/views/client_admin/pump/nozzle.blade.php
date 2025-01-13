@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Nozzles</span>
                </h3>

                <div class="card-toolbar" >
                    <a href="#" class="btn btn-sm btn-light btn-active-primary new_modal" data-bs-toggle="modal"
                        data-bs-target="#nozzle_modal">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                </rect>
                            </svg>
                        </span>
                        New Nozzle
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="nozzle_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-150px">Fuel Type</th>
                                <th class="min-w-150px">Tank Name</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <form action="" method="POST" id="nozzle_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="nozzle_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Nozzle</h5>

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
                            <label for="nozzles_date" class="form-label">Date</label>
                            <input type="date" class="form-control form-control-solid" id="nozzles_date" name="nozzles_date" />
                        </div>

                        <div class="fv-row mb-5">
                            <label class="d-flex align-items-center fs-5 fw-bold mb-3" for="fuel_type_id">
                                <span class="required">Select Fuel type</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select Carefully"></i>
                            </label>
                            <select class="form-select form-select-solid" name="fuel_type_id" id="fuel_type_id" aria-label="Select example">
                                <option disabled selected value>Open this menu</option>
                                @foreach ($fuel_types as $fuel_type)
                                    <option value="{{$fuel_type->id}}">{{$fuel_type->name}}</option>
                                @endforeach
                            </select>
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

                        <div class="fv-row mb-5">
                            <label for="name" class="required form-label">Nozzle Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Name of Nozzle" id="name" name="name" />
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <label for="analog_reading" class="form-label">Hidden Reading</label>
                                <input
                                    type="number"
                                    class="form-control form-control-solid"
                                    placeholder="Enter analog reading"
                                    id="analog_reading"
                                    name="analog_reading"
                                    step="0.01"
                                />
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="digital_reading" class="form-label">Digital Reading</label>
                                <input
                                    type="number"
                                    class="form-control form-control-solid"
                                    placeholder="Enter digital reading"
                                    id="digital_reading"
                                    name="digital_reading"
                                    step="0.01"
                                />
                            </div>
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
                    dt = $("#nozzle_table").DataTable({
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
                            url: `/pump/${pumpId}/nozzle/get_all`,
                        },
                        columns: [{
                                data: 'id'
                            },
                            {
                                data: 'name'
                            },
                            {
                                data: 'fuel_type_name'
                            },
                            {
                                data: 'tank_name'
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
                                    return `<button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 edit_btn" data-bs-toggle="modal" data-bs-target="#nozzle_modal" data-obj='${JSON.stringify(row)}'>
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

            $("#fuel_type_id").change(function() {
                var fuelTypeId = $(this).val();
                if (fuelTypeId) {
                    $.ajax({
                        url: `/pump/${pumpId}/nozzle/getTanksByFuelType`,
                        type: 'GET',
                        data: {
                            fuel_type_id: fuelTypeId
                        },
                        success: function(response) {
                            if (response.success) {
                                var tankSelect = $('#tank_id');
                                tankSelect.empty();
                                tankSelect.append('<option disabled selected value>Open this menu</option>');
                                $.each(response.tanks, function(index, tank) {
                                    tankSelect.append('<option value="' + tank.id + '">' + tank.name + '</option>');
                                });
                            }
                        }
                    });
                }
            });


            $('#nozzle_table').on('click', '.edit_btn', function() {
                const dataObj = JSON.parse($(this).attr('data-obj'));
                $('#id').val(dataObj.id);
                $('#name').val(dataObj.name);
                $('#fuel_type_id').val(dataObj.fuel_type_id).trigger('change');

                const tankId = dataObj.tank_id;
                const dropdown = $('#tank_id');

                const optionExists = dropdown.find(`option[value="${tankId}"]`).length > 0;

                if (optionExists) {
                    dropdown.val(tankId).trigger('change');
                } else {
                    console.error('The specified tankId does not exist in the dropdown.');
                }
            });

            let prefix = `pump/${pumpId}`
            handlingForms('nozzle', prefix);
            deleteFn('nozzle', prefix)
        });


    </script>
@endsection


@section('styles')
@endsection
