<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = ['name'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function rentProperties()
    {
        return $this->hasMany(RentProperty::class);
    }
}
