@extends('layouts.app')

@section('main-content')
    <div class="container-xxl mt-5">
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Accounts</span>
                </h3>

                <div class="card-toolbar">
                    <a href="#" class="btn btn-sm btn-primary btn-active-primary new_modal" data-bs-toggle="modal"
                        data-bs-target="#customer_modal">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black">
                                </rect>
                            </svg>
                        </span>
                        Add Account
                    </a>
                </div>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="customer_table">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true"
                                            data-kt-check-target=".widget-9-check">
                                    </div>
                                </th>
                                <th class="min-w-150px">Account Title</th>
                                <th class="min-w-150px">Bank Name</th>
                                <th class="min-w-150px">Person Name</th>
                                <th class="min-w-150px">Account Number</th>
                                <th class="min-w-150px">Total Cash</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding accounts -->
    <form action="/accounts" method="POST" id="account_form" class="validate-form">
        <div class="modal fade" tabindex="-1" id="customer_modal">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">Add Account</h5>
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
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" />
                        @csrf

                        <div class="fv-row mb-5">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control form-control-solid" id="date" name="date" required />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="account_title" class="required form-label">Account Title</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Saving" id="account_title" name="account_title" required />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="bank_name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="UBL" id="bank_name" name="bank_name" required />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="person_name" class="form-label">Person Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Name" id="person_name" name="person_name" required />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="number" class="form-control form-control-solid" placeholder="Enter account number" id="account_number" name="account_number" required />
                        </div>

                        <div class="fv-row mb-5">
                            <label for="previous_cash" class="form-label">Previous Cash</label>
                            <input type="number" class="form-control form-control-solid" placeholder="Enter amount" id="previous_cash" name="previous_cash" required />
                        </div>
                    </div>

                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary submit_btn" id="account_submit">Save</button>
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

        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle form submission
        $('#account_form').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = $(this).serialize(); // Get form data

            // Send data via AJAX
            $.ajax({
                url: '/accounts', // Replace with your route
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Account data has been successfully saved.');
                        $('#account_form')[0].reset(); // Clear the form
                        $('#customer_modal').modal('hide'); // Hide the modal
                    } else {
                        alert('There was an error saving the data.');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred while saving the data: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<!-- Add any custom styles here -->
@endsection