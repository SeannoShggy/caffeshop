<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'stock',
        'image',
    ];

    /**
     * Relasi ke order_items
     * (1 produk bisa ada di banyak order)
     */
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}
