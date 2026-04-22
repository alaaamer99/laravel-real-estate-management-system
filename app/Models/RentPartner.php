<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentPartner extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email', 
        'commission_rate',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function rentProperties()
    {
        return $this->hasMany(RentProperty::class);
    }
}
