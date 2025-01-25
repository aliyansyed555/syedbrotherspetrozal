<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelPrice extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'fuel_prices';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'selling_price',
        'buying_price',
        'fuel_type_id',
        'petrol_pump_id',
        'date',
        'loss_gain_value',
        'is_hidden',
    ];

    // Define the relationships

    // FuelPrice belongs to FuelType
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id');
    }

    // FuelPrice belongs to PetrolPump
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class, 'petrol_pump_id');
    }
}
