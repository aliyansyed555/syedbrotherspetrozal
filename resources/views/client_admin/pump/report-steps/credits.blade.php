<div class="flex-column" data-kt-stepper-element="content">

    <div class="row position-relative">
        <div class="col-md-6 mb-5">
            <div class="fv-row">
                <label class="required form-label" for="customer_id">Customer</label>
                <select class="form-select form-select-solid" data-control="select2" id="customer_id" name="customer_id"></select>
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="fv-row">
                <label class="required form-label" for="bill_amount">Bill Amount</label>
                <input type="text" class="form-control form-control-solid" placeholder="00" id="bill_amount" name="bill_amount" />
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="fv-row">
                <label class="required form-label" for="amount_paid">Amount Received</label>
                <input type="text" class="form-control form-control-solid" placeholder="00" id="amount_paid" name="amount_paid" />
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="fv-row">
                <label class="required form-label" for="remarks">Comment</label>
                <input type="text" class="form-control form-control-solid" placeholder="Detail About Credit" id="remarks" name="remarks" />
            </div>
        </div>

        <div class="col-md-4 mt-5">
            <button type="button" class="btn btn-primary" id="add_credit">Add Credit</button>
        </div>
    
    </div>
        
    <!-- Table to display selected customers credits -->
    <div class="mt-5" id="credit_table_container" style="display:none;">
        <table class="table table-rounded table-row-bordered border gy-7 gs-7" id="credit_table">
            <thead>
                <tr>
                    <th class="fw-bolder fs-6 p-5">Customer</th>
                    <th class="fw-bolder fs-6 p-5">Amount</th>
                    <th class="fw-bolder fs-6 p-5">Paid</th>
                    <th class="fw-bolder fs-6 p-5">Balance</th>
                    <th class="fw-bolder fs-6 p-5">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!-- Total Price Display -->
        <div class="mt-3 text-end">
            <h5>Total Price: <span id="total_credit">0</span></h5>
        </div>
    </div>



</div>

