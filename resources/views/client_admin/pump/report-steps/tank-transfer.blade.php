<div class="flex-column" data-kt-stepper-element="content">
    <div class="row">

        @foreach ($tanks as $tank)
            <div class="col-md-6 fv-row mb-5">
                <label class="required form-label" for="tank_{{ $tank->id }}_ltr">Tank {{ $tank->name }} Quantity ltr</label>
                <input type="text" data-tanks-fuel-type-id="{{ $tank->fuel_type_id }}" class="form-control form-control-solid tank-transfer-input" placeholder="00" id="tank_{{ $tank->id }}_ltr" name="tank_transfers[{{ $tank->id }}][quantity_ltr]"/>
            </div>
        @endforeach
        

    </div>
</div>

