<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'order_type',
        'total_amount',
        'payment_status',
        'order_status',
        'midtrans_snap_token',
        'midtrans_order_id',
        'scheduled_pickup'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}