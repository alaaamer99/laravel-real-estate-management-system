<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'reference_number', 'date', 'ad_side', 'partners_count',
        'address', 'area', 'units_number', 'description', 'price',
        'price_status', 'annual_return', 'price_per_foot', 'is_ad',
        'status', 'property_type_id', 'created_by'
    ];

    protected $casts = [
        'date' => 'date',
        'is_ad' => 'boolean',
        'area' => 'decimal:2',
        'price' => 'decimal:2',
        'annual_return' => 'decimal:2',
        'price_per_foot' => 'decimal:2'
    ];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'property_partner');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
