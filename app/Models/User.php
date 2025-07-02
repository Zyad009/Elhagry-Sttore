<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function () {
                return "{$this->first_name} {$this->last_name}";
            })
            ->saveSlugsTo("slug");
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'whatsapp',
        'address',
        'phone',
        'slug',
    ];



    public function orders()
    {
        return $this->hasMany(order::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function getDefaultImageAttribute()
    {
        $image = $this->images->first()?->main_image;

        if (!$image) {
            if ($this->gender == 'male') {
                $image = config('default-image.male-image');
            } else {
                $image = config('default-image.female-image');
            }
        }
        return $image;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
