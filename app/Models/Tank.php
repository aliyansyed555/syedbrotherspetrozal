<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'tanks';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'name',
        'fuel_type_id',
        'petrol_pump_id',
    ];

    // Define the relationships

    // FuelPrice belongs to FuelType
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id');
    }

    public function tankStocks()
    {
        return $this->hasMany(TankStock::class, 'tank_id');
    }
    public function dipRecords()
    {
        return $this->hasMany(DipRecord::class, 'tank_id');
    }
    
    public function nozzles()
    {
        return $this->hasMany(Nozzle::class);
    }
    public function tankTransfers()
    {
        return $this->hasMany(TankTransfer::class);
    }

    // FuelPrice belongs to PetrolPump
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class, 'petrol_pump_id');
    }
}
