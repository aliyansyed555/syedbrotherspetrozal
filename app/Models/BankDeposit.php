<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'pump_id',
        'bank_deposit',
        'account_number',
        'expense_detail',
    ];
}
