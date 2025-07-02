<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PickupPoint extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public function saleOfficer()
    {
        return $this->hasOne(SaleOfficer::class);
    }

    public function Order()
    {
        return $this->hasMany(Order::class);
    }
}
