<div class="flex-column" data-kt-stepper-element="content">

    <div class="row position-relative">
        <div class="col-md-5">
            <div class="fv-row">
                <label class="required form-label" for="product_id">Product</label>
                <select class="form-select form-select-solid" data-control="select2" id="product_id" name="product_id">
                </select>
            </div>
        </div>

        <div class="col-md-5">
            <div class="fv-row">
                <label class="required form-label" for="quantity">Quantity</label>
                <input type="number" class="form-control form-control-solid" placeholder="Quantity" id="quantity" name="quantity" />
            </div>
        </div>

        <div class="col-md-2 position-absolute bottom-0 end-0">
            <button type="button" class="btn btn-primary" id="add_product">Add</button>
        </div>
    
    </div>
        
    <!-- Table to display selected products -->
    
    <div class="mt-5" id="product_table_container" style="display:none;">
        <table class="table table-rounded table-row-bordered border gy-7 gs-7" id="product_table">
            <thead>
                <tr>
                    <th class="fw-bolder fs-6 p-5">Product</th>
                    <th class="fw-bolder fs-6 p-5">Price</th>
                    <th class="fw-bolder fs-6 p-5">Quantity</th>
                    <th class="fw-bolder fs-6 p-5">Total</th>
                    <th class="fw-bolder fs-6 p-5">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <!-- Total Price Display -->
        <div class="mt-3 text-end">
            <h5>Total Price: <span id="total_price">0</span></h5>
        </div>
    </div>



</div>

