<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetrolPump extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'company_id',
    ];

    // Define the relationship with the 'Company' model
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function fuelPrices()
    {
        return $this->hasMany(FuelPrice::class);
    }

    public function tanks()
    {
        return $this->hasMany(Tank::class);
    }

    public function nozzles()
    {
        return $this->hasMany(Nozzle::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }

    public function cardPayments()
    {
        return $this->hasMany(CardPayment::class);
    }

    public function cardPaymentTransfers()
    {
        return $this->hasMany(CardPaymentsTransfer::class);
    }
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function fuelPurchases()
    {
        return $this->hasMany(FuelPurchase::class);
    }
    protected static function booted()
    {
        static::addGlobalScope('company', function ($query) {
            $user = auth()->user();
    
            if ($user->hasRole('client_admin') && $user->company) {
                // Apply scope for client_admin
                $query->where('company_id', $user->company->id);
            } elseif ($user->hasRole('manager') && $user->teamMembers->isNotEmpty()) {
                // Apply scope for manager
                $query->where('company_id', $user->teamMembers->first()->company_id);
            }
        });
    }
}
