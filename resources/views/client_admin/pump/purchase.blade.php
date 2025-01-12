@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        {{-- <h1>{{$pump->name}}</h1> --}}
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <div class="d-flex align-items-center position-relative my-1">
                        <div class="mb-0">
                            <input class="form-control form-control-solid" data-kt-docs-table-filter="search" placeholder="Pick date rage" id="kt_daterangepicker"/>
                        </div>
                    </div>
                </h3>

                <div class="card-toolbar" >
                    <a href="#" class="btn btn-sm btn-light btn-active-primary new_modal" data-bs-toggle="modal"
                        data-bs-target="#purchase_modal">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                </rect>
                            </svg>
                        </span>
                        New Purchase
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="purchase_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Fuel Type</th>
                                <th class="min-w-150px">Quantity</th>
                                <th class="min-w-150px">Buying Price</th>
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

    <form method="POST" id="purchase_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="purchase_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Purchase</h5>

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
                                <span class="required">Date</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Select a date."></i>
                            </label>
                            <input class="form-control form-control-solid date_picker" placeholder="Pick date" name="purchase_date" id="purchase_date"/>
                        </div>

                        <div class="fv-row mb-5">
                            <label class="d-flex align-items-center fs-6 mb-3" for="fuel_type">
                                <span class="required">Select the Fuel type</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Select Carefully"></i>
                            </label>
                            <div class="btn-group w-100" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                                @foreach ($fuel_types as $fuel_type)
                                <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success"data-kt-button="true">
                                    <input class="btn-check" type="radio" name="fuel_type_id" value="{{$fuel_type->id}}" />
                                    {{$fuel_type->name}}
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="fv-row mb-5">
                            <label for="fuel_quantity" class="required form-label">Quantity Ltr</label>
                            <input type="text" class="form-control form-control-solid" value="0"  id="fuel_quantity" name="fuel_quantity" />
                        </div>

                        <div class="fv-row mb-5">
                            <label class="required form-label">Quantity in Tank</label>
                            <div id="tank-container">
                                <i>Select Fuel Type please firs*</i>
                            </div>
                        </div>

                        <div class="fv-row mb-5">
                            <label for="buying_price_per_ltr" class="required form-label">Buying Price Per Ltr</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Price goes here" id="buying_price_per_ltr" name="buying_price_per_ltr" />
                        </div>

                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="purchase_submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            "use strict";
            let startDate = null;
            let endDate = null;

            $("#kt_daterangepicker").daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                $("#purchase_table").DataTable().draw();
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    if (settings.nTable.id !== 'purchase_table') {
                        return true;
                    }
                    const rowDate = data[3]; // Date column index
                    if (startDate && endDate) {
                        return rowDate >= startDate && rowDate <= endDate;
                    }
                    return true;
                }
            );

            var pumpId = @json($pump_id);
            // Class definition
            var KTDatatablesServerSide = function() {
                // Shared variables

                var table;
                var dt;

                // Private functions
                var initDatatable = function() {
                    dt = $("#purchase_table").DataTable({
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
                            url: `/pump/${pumpId}/purchase/get_all`,
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
                                data: 'fuel_type_name'
                            },
                            {
                                data: 'quantity_ltr'
                            },
                            {
                                data: 'buying_price_per_ltr'
                            },
                            {
                                data: 'purchase_date'
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
                                    return `
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

            let fv; // Define fv in a broader scope

            $('input[name="fuel_type_id"]').on('change', function () {
                let fuelTypeId = $(this).val();
                $.ajax({
                    url: `/pump/getTanksByFuelType`,
                    method: 'POST',
                    data: {
                        petrol_pump_id: pumpId,
                        fuel_type_id: fuelTypeId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#tank-container').html(''); // Clear previous tank fields
                        response.tanks.forEach(function (tank) {
                            $('#tank-container').append(`
                                <div class="tank-item">
                                    <div class="input-group mb-5">
                                        <span class="input-group-text" id="basic-addon3">${tank.name}</span>
                                        <input type="text" class="form-control tank-stock-input" value="0" data-tank-id="${tank.id}" aria-describedby="basic-addon3" name="tank_stocks[]" />
                                    </div>
                                </div>
                            `);
                        });

                        // Reinitialize FormValidation with new fields
                        fv = FormValidation.formValidation(
                            document.getElementById('purchase_form'),
                            {
                                fields: {
                                    'fuel_quantity': {
                                        validators: {
                                            notEmpty: {
                                                message: 'Quantity cannot be empty'
                                            },
                                            regexp: {
                                                regexp: /^[0-9]+(\.[0-9]{1,2})?$/,
                                                message: 'Please enter a valid number (no letters allowed)'
                                            }
                                        }
                                    },
                                    'purchase_date':{
                                        validators: {
                                            notEmpty: {
                                                message: 'The date cannot be empty'
                                            },
                                        }
                                    },
                                    'buying_price_per_ltr':{
                                        validators: {
                                            notEmpty: {
                                                message: 'The Buying Price cannot be empty'
                                            },
                                        }
                                    },
                                    'fuel_type_id':{
                                        validators: {
                                            notEmpty: {
                                                message: 'The Fuel type cannot be empty'
                                            },
                                        }
                                    },
                                    'tank_stocks[]': {
                                        validators: {
                                            notEmpty: {
                                                message: 'Quantity cannot be empty'
                                            },
                                            callback: {
                                                message: 'The total quantity of fuel must match the sum of all tank inputs',
                                                callback: function (input) {
                                                    const totalQuantity = parseFloat(document.querySelector('[name="fuel_quantity"]').value) || 0;
                                                    const tankInputs = document.querySelectorAll('.tank-stock-input');

                                                    let sumOfTanks = 0;
                                                    tankInputs.forEach(function (tankInput) {
                                                        sumOfTanks += parseFloat(tankInput.value) || 0;
                                                    });

                                                    return sumOfTanks === totalQuantity;
                                                },
                                            },
                                        },
                                    },
                                },
                                plugins: {
                                    trigger: new FormValidation.plugins.Trigger(),
                                    bootstrap: new FormValidation.plugins.Bootstrap5({
                                        rowSelector: '.fv-row',
                                        eleInvalidClass: '',
                                        eleValidClass: ''
                                    })
                                }
                            }
                        );
                        $(document).on('input', '.tank-stock-input', function () {
                            fv.revalidateField('tank_stocks[]');  // Revalidate the field when the user inputs a value
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching tanks: ", error);
                        alert("Failed to fetch tanks. Please try again.");
                    }
                });
            });

            // Form submission handling
            $('#purchase_form').on('submit', function (e) {
                e.preventDefault(); // Prevent form submission to validate first
                var formData = new FormData(this);

                var tankStocks = [];
                $('.tank-stock-input').each(function() {
                    var tankId = $(this).data('tank-id');
                    var stockQuantity = $(this).val();
                    tankStocks.push({ tank_id: tankId, quantity: stockQuantity });
                });

                // Append the tank data manually to formData
                formData.append('tank_stocks', JSON.stringify(tankStocks));

                // Optionally, you can add any other extra data, like pumpId
                formData.append('pump_id', pumpId);
                fv.validate().then(function (status) {
                    if (status === 'Valid') {
                        $.ajax({
                            url: `/pump/${pumpId}/purchase/create`,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    toastr.success("Data Successfully Saved!");
                                    $('#purchase_modal').modal('hide');
                                    $('#purchase_form').trigger('reset');
                                    $('#purchase_table').DataTable().ajax.reload();

                                } else {
                                    toastr.err('There was an error saving the data.');
                                }
                            },
                            error: function(xhr, status, error) {
                                toastr.error('Failed to save the data. Please try again.');
                            }
                        });
                    } else {
                        console.log('Form is invalid!');
                    }
                });
            });


            // $('#purchase_table').on('click', '.edit_btn', function (e) {
            //     e.preventDefault();

            //     const dataObj = JSON.parse($(this).attr('data-obj'));
            //     console.log(dataObj);

            //     $('#id').val(dataObj.id);
            //     $('#selling_price').val(dataObj.selling_price);
            //     $('#date').val(dataObj.date);

            //     $(`input[name="fuel_type_id"][value="${dataObj.fuel_type_id}"]`).prop('checked', "checked");
            //     $(`input[name="fuel_type_id"][value="${dataObj.fuel_type_id}"]`).closest('label').addClass('active');
            //     // Show the modal
            //     $('#purchase_modal').modal('show');
            // });



            let prefix = `pump/${pumpId}`
            // handlingForms('purchase', prefix);
            deleteFn('purchase', prefix)
        });


    </script>
@endsection


@section('styles')
@endsection
