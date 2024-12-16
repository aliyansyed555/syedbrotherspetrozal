<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NozzleReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'analog_reading',
        'digital_reading',
        'date',
        'nozzle_id'
    ];

    public function nozzle()
    {
        return $this->belongsTo(Nozzle::class);
    }
}
