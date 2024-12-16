<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TankTransfer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tank_transfers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity_ltr',
        'date',
        'tank_id',
        'created_at',
    ];

    /**
     * Get the tank associated with the transfer.
     */
    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}
