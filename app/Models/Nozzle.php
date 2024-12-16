<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nozzle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  
        'petrol_pump_id',  
        'tank_id',  
        'fuel_type_id'  
    ];


    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }

    /**
     * The nozzle readings for this nozzle.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nozzleReadings()
    {
        return $this->hasMany(NozzleReading::class, 'nozzle_id');
    }
}
