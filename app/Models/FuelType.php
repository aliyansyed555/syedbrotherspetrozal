<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  
        'company_id',  
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function nozzles()
    {
        return $this->hasMany(Nozzle::class);
    }
    
    public function tanks()
    {
        return $this->hasMany(Tank::class);
    }
    
    public function fuelPurchases()
    {
        return $this->hasMany(FuelPurchase::class);
    }
}
