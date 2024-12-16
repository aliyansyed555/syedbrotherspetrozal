<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeWage extends Model
{
    protected $fillable = [
        'amount_received',  
        'employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
