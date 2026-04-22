<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['name'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_partner');
    }
}
