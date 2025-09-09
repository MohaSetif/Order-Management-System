<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'platform',
        'customer_name',
        'customer_email',
        'customer_phone',
        'items',
        'payment_mode',
        'cod_amount',
        'advance_amount',
        'total',
        'shipping_address',
        'city',
        'state',
        'pincode',
        'courier_aggregator_id',
        'is_pushed',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function courierAggregator()
    {
        return $this->belongsTo(CourierAggregator::class);
    }

    public static function boot()
    {
        parent::boot();

        // Generate unique OMS order_id if not set
        static::creating(function ($order) {
            if (empty($order->order_id)) {
                $order->order_id = 'OMS-' . strtoupper(uniqid());
            }
        });
    }
}
