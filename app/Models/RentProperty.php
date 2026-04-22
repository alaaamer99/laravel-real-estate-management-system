<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentProperty extends Model
{
    protected $fillable = [
        'property_number',
        'date',
        'property_type_id',
        'rent_partner_id',
        'address',
        'rooms',
        'bathrooms',
        'description',
        'area',
        'rental_type',
        'price',
        'payment_installments',
        'status',
        'images'
    ];

    protected $casts = [
        'date' => 'date',
        'area' => 'decimal:2',
        'price' => 'decimal:2',
        'payment_installments' => 'integer',
        'images' => 'array',
    ];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function rentPartner()
    {
        return $this->belongsTo(RentPartner::class);
    }

    public function getRentalTypeTextAttribute()
    {
        return match($this->rental_type) {
            'monthly' => 'شهري',
            'quarterly' => 'ربع سنوي',
            'semi_annual' => 'نصف سنوي',
            'annual' => 'سنوي',
            default => $this->rental_type,
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'available' => 'متاح',
            'rented' => 'مؤجر',
            default => $this->status,
        };
    }
}
