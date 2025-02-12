<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts'; // Database table ka naam

    protected $fillable = [
        'account_name',
        'bank_name',
        'person_name',
        'account_number',
        'previous_cash',
        'date',
    ];
}
