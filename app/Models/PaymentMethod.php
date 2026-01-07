<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'type',
        'details',
        'active',
    ];

    protected $casts = [
        'details' => 'array',
        'active' => 'boolean',
    ];
}
