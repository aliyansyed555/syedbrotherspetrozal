<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory trait

class DipComparison extends Model
{
    use HasFactory;

    protected $fillable = [
        'tank_dip',
        'tank_stock',
        'previous_stock',
        'final_dip',
        'report_date',
        'fuel_type_id',
        'pump_id',
    ];
}
