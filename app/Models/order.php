<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'zip_code',
        'cart_id',
        'total_amount',
        'payment_method',
        'status',
    ];

    public function cartItems()
    {
        return $this->belongsToMany(Cart::class);
    }
}