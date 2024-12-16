<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class TeamMember extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'user_id',
        'company_id',
    ];

    /**
     * Get the user that owns the team member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that the team member belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
