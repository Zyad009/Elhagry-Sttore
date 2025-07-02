<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'user_id',
        'city_id',
        'area_id',
        'building',
        'floor',
        'apartment',
        'address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
