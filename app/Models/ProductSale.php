<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'products',
        'petrol_pump_id',
        'date',
    ];

    /**
     * Cast products JSON to array.
     */
    protected $casts = [
        'products' => 'array',
    ];

    /**
     * Relationship with PetrolPump (if needed).
     */
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }
}
