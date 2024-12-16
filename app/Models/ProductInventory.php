<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;
    protected $table = 'product_inventory';
    protected $fillable = [
        'product_id',
        'quantity',
        'date',
    ];

    /**
     * Relationship with Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
