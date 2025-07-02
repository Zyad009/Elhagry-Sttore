<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_name',
        'QTY',
        'price',
        'color',
        'size',
        'discount',
        'discount_type',
        'final_price',
        'slug',
        'modification_reason',
        'cancel_reason',
        'QTY_delete',
        'QTY_edit',
        'status_modification',
        'status_cancelled',
        'status',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
