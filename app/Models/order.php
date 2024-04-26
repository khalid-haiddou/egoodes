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
        return $this->hasMany(Cart::class, 'id', 'cart_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Cart::class, 'id', 'product_id', 'cart_id', 'product_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'cart_id');
    }
}