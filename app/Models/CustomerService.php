<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerService extends Authenticatable
{
    use HasFactory, HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom("name")
            ->saveSlugsTo("slug");
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    protected $fillable = ["name"];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
