<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CustomerCredit extends Model
{
    protected $fillable = [
        'bill_amount',
        'amount_paid',
        'balance',
        'remarks',
        'date',
        'customer_id'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
