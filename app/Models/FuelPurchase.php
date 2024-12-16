<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelPurchase extends Model
{
    protected $fillable = [
        'petrol_pump_id',
        'fuel_type_id',
        'quantity_ltr',
        'buying_price_per_ltr',
        'purchase_date',
    ];
   
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }
}
