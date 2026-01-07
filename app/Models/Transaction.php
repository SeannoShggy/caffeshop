<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'phone',
        'product_id',
        'quantity',
        'price',
        'total',
        'transaction_date',
        'type',
        'note',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function items()
{
    return $this->hasMany(Transaction::class);
}

}
