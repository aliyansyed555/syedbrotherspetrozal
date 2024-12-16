<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'price',
        'buying_price',
        'petrol_pump_id',
    ];

    /**
     * Relationship with ProductInventory.
     */
    public function inventories()
    {
        return $this->hasMany(ProductInventory::class);
    }

    /**
     * Relationship with PetrolPump (if needed).
     */
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }
}

