<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'category',
        'price',
        'quantity',
        'image',
        'short_description',
        'status',
    ];

    // Define relationship with User model
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}