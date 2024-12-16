<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  
        'user_id',
        'address',
    ];
    
    // Define the relationship with the 'User' (the client_admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the 'TeamMember' model
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function fuelTypes()
    {
        return $this->hasMany(FuelType::class);
    }

    // Define the relationship with the 'PetrolPump' model
    public function petrolPumps()
    {
        return $this->hasMany(PetrolPump::class);
    }
}
