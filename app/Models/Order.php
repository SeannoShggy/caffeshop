<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'phone',
        'cart',
        'note',
        'total',
        'status',
        'payment_status',
        'payment_proof',
    ];

    protected $casts = [
        'cart' => 'array',
    ];
}
