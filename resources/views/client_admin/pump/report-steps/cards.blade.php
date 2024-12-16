<div class="flex-column" data-kt-stepper-element="content">

    <div class="row position-relative">

        <div class="col-md-6 mb-5">
            <div class="fv-row">
                <label class="required form-label" for="card_number">Card Number</label>
                <input type="text" class="form-control form-control-solid" placeholder="0000 1111 2222 8888" id="card_number" name="card_number" />
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="fv-row">
                <label class="required form-label" for="amount">Amount</label>
                <input type="text" class="form-control form-control-solid" placeholder="00" id="amount" name="amount" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="fv-row">
                <label class="required form-label" for="card_type">Card Type</label>
                <select class="form-select form-select-solid" id="card_type" name="card_type">
                    <option value="PSO">PSO</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="col-md-4 position-absolute bottom-0 end-0">
            <button type="button" class="btn btn-primary" id="add_card_payment">Add Credit</button>
        </div>
    
    </div>
        
    <!-- Table to display selected customers credits -->
    <div class="mt-5" id="card_payments_container" style="display:none;">
        <table class="table table-rounded table-row-bordered border gy-7 gs-7" id="card_payments_table">
            <thead>
                <tr>
                    <th class="fw-bolder fs-6 p-5">Card Number</th>
                    <th class="fw-bolder fs-6 p-5">Amount</th>
                    <th class="fw-bolder fs-6 p-5">Card Type</th>
                    <th class="fw-bolder fs-6 p-5">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!-- Total Price Display -->
        <div class="mt-3 text-end">
            <h5>Total Price: <span id="total_card_payments">0</span></h5>
        </div>
    </div>



</div>

