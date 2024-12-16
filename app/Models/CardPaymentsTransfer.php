<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPaymentsTransfer extends Model
{
    protected $table = 'card_payments_transfers';

    protected $fillable = [
        'amount',
        'account_number',
        'petrol_pump_id',
        'date',
    ];

    public function petrolPump()
    {
        return $this->belongsTo(PetrolPump::class, 'petrol_pump_id');
    }
}
