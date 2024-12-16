<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TankStock extends Model
{
    use HasFactory;
    protected $table = 'tank_stocks';

    protected $fillable = [
        'reading_in_ltr',
        'tank_id',
        'date'
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::class, 'tank_id'); // 'tank_id' is the foreign key in the 'tank_stocks' table
    }
}
