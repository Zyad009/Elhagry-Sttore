<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    public $translatable = ['name'];

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
        'id',
        'name',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany(Category::class, "parent_id");
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function products()
    {
        return $this->hasMany(product::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
