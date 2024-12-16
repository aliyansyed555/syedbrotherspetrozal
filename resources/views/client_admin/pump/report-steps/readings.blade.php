<div class="flex-column current" data-kt-stepper-element="content">
    <div class="fv-row mb-5 col-md-6 ">
        <label class="fs-6 fw-bold form-label mb-2">
            <span class="required">Date </span>
        </label>
        <input class="form-control form-control-solid date_picker" placeholder="Pick date" name="date" id="date"/>
    </div>
    @foreach ($nozzles->groupBy('fuel_type_id') as $fuelTypeId => $groupedNozzles)
        <h2 class="fw-bold text-dark">{{ $groupedNozzles->first()->fuelType->name }}</h2>
        @foreach ($groupedNozzles as $nozzle)
            <div class="row mb-5">
                <div class="fv-row col-md-6 ">
                    <label class="required fs-6 fw-bold mb-2" for="readings[{{ $nozzle->id }}][analog_reading]">
                        {{ $nozzle->name }} - Hidden: 
                        <span>
                            {{ $nozzle->nozzleReadings->first() ? $nozzle->nozzleReadings->first()->analog_reading : '0' }}
                        </span>
                    </label>
                    <input type="text" class="form-control form-control-solid" data-fuel-type-id="{{ $fuelTypeId }}" id="readings[{{ $nozzle->id }}][analog_reading]" name="readings[{{ $nozzle->id }}][analog_reading]" value="{{ $nozzle->nozzleReadings->first() ? $nozzle->nozzleReadings->first()->analog_reading : '0' }}"/>
                </div>

                <div class="fv-row col-md-6">
                    <label class="required fs-6 fw-bold mb-2" for="readings[{{ $nozzle->id }}][digital_reading]">
                        {{ $nozzle->name }} - Digital : 
                        <span>
                            {{ $nozzle->nozzleReadings->first() ? $nozzle->nozzleReadings->first()->digital_reading : '0' }}
                        </span>    
                    </label>
                    <input type="text" 
                        class="form-control form-control-solid track_change fuel-input" 
                        data-fuel-type-id="{{ $fuelTypeId }}" 
                        data-last-reading="{{ $nozzle->nozzleReadings->first() ? $nozzle->nozzleReadings->first()->digital_reading : '0' }}" 
                        id="readings[{{ $nozzle->id }}][digital_reading]" 
                        name="readings[{{ $nozzle->id }}][digital_reading]" 
                        value="{{ $nozzle->nozzleReadings->first() ? $nozzle->nozzleReadings->first()->digital_reading : '0' }}" 
                        id="readings[{{ $nozzle->id }}][digital_reading]"
                    />
                </div>
            </div>
        @endforeach
        <div class="separator separator-solid mb-7"></div>
    @endforeach

</div>