<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DipRecord extends Model
{
    use HasFactory;

    // protected $table = 'dip_records';

    protected $fillable = [
        'reading_in_mm',
        'reading_in_ltr',
        'date',
        'tank_id',
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::class, 'tank_id');
    }
}
