<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPayment extends Model
{
    protected $fillable = [
        'card_number',
        'amount',
        'card_type',
        'account_number',
        'transaction_type',
        'remarks',
        'petrol_pump_id',
        'date',
    ];


    /**
     * Get the petrol pump associated with this card payment.
     */
    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class, 'petrol_pump_id');
    }
}
