<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  
        'phone',
        'address',
        'petrol_pump_id'
    ];


    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }

    public function credits()
    {
        return $this->hasMany(CustomerCredit::class, 'customer_id', 'id');
    }

}
