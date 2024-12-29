@extends('layouts.app')

@section('main-content')
    <div class="m-2">
        <div class="card">
            <div class="card-body">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-3">
                    <div class="d-flex align-items-center position-relative my-1">
                        <h3>Welcome to {{ $companyName }}</h3>
                    </div>

                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected
                        </div>
                        <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Selection Action</button>
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
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {

            "use strict";
            var KTDatatablesServerSide = function() {

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
                                    return `<a target="_blank" href="/pump/${row.id}/analytics" class="btn btn-sm btn-primary">Analytics</a>
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

            deleteFn('pump');
            handlingForms('pump');
        });
    </script>
@endsection
