                        
<div class="flex-column" data-kt-stepper-element="content">
    <div class="row position-relative">
        <div class="col-md-5">
            <div class="fv-row">
                <label class="required form-label" for="employee_id">Employee</label>
                <select class="form-select form-select-solid" data-control="select2" id="employee_id" name="employee_id">
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="fv-row">
                <label class="required form-label" for="salary">Amount</label>
                <input type="number" class="form-control form-control-solid" placeholder="00" id="salary" name="salary" />
            </div>
        </div>

        <div class="col-md-2 position-absolute bottom-0 end-0">
            <button type="button" class="btn btn-primary" id="add_wage">Add</button>
        </div>
    </div>

    <!-- Table to display selected products -->
    <div class="mt-5" id="wages_table_container" style="display:none;">
        <table class="table table-rounded table-row-bordered border gy-7 gs-7" id="wages_table">
            <thead>
                <tr>
                    <th class="fw-bolder fs-6 p-5">Employee</th>
                    <th class="fw-bolder fs-6 p-5">Amount</th>
                    <th class="fw-bolder fs-6 p-5">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!-- Total Price Display -->
        <div class="mt-3 text-end">
            <h5>Total Wages: <span id="total_wages">0</span></h5>
        </div>
    </div>
</div>