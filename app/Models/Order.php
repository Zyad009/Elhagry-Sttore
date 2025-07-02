<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if ($order->delivery_method === 'delivery') {
                $order->status_order = 'pending';
            } elseif ($order->delivery_method === 'pickup') {
                $order->status_order = 'accepted';
            }
        });
    }
    protected $fillable = [
        'user_id', //
        'pickup_points_id',
        'payment_method',
        'payment_status',
        'delivery_method',
        'delivery_type',
        'city', //
        'area', //
        'pickup_code',
        'follow_up_code', //
        'total', //
        'delivery_price', //
        'total_discount', //
        'finally_total', //
        'name', //
        'phone', //
        'email', //
        'status_order', //
        'status', //
        'modification_reason',
        'cancel_reason', //
        'order_date',  //
        'notes', //
        'status_details',
        'address_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickupPoint()
    {
        return $this->belongsTo(PickupPoint::class, 'pickup_points_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
