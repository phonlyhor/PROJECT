<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_item'; // database table name

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'image',
    ];

    // Optional: define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: define relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}