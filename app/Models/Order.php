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
        'payment_proof',
        'scheduled_pickup',
        'delivery_session',
        'delivery_date'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}