<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

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

    protected $fillable = [
        'name',
        'price',
        'offer_id',
        'description',
        'QTY',
        'sold',
        'image',
        'category_id',
        'type_size',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    protected $casts = [
        // 'sizes' => 'array', 
    ];


    public function getFinalPriceDetails()
    {
        $price = $this->price;

        if ($this->offer) {
            $discount = $this->offer->discount;
            $discountType = $this->offer->discount_type;

            if ($this->offer->discount_type == 'percentage') {
                $final = $price - ($price * $discount / 100);
                $mark = '%';
            } else {
                $final = $price - $discount;
                $mark = 'EGP';
            }

            return [
                'original' => $price,
                'final' => round($final, 2),
                'discountType' => $discountType,
                'discount' => $discount,
                'mark' => $mark,
            ];
        }

        return [
            'original' => $price,
            'final' => $price,
            'discountType' => null,
            'discount' => 0,
            'mark' => '',
        ];
    }
}
