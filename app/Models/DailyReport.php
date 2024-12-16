<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'daily_expense',
        'expense_detail',
        'pump_rent',
        'bank_deposit',
        'cash_in_hand',
        'account_number',
        'date',
        'petrol_pump_id',
    ];

    
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class);
    }
    
}
