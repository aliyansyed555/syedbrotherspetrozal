<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',  
        'phone',
        'address',
        'petrol_pump_id',
        'total_salary',
    ];


    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }
    public function wages(){
        return $this->hasMany(EmployeeWage::class);
    }
}
