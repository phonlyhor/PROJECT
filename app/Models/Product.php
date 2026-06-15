<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $table = 'products';

    protected $fillable = [
        'ProductName',
        'Price',
        'ProductImage',
        'CategoryID',
    ];
    public function Category()
{
    return $this->belongsTo(Category::class, 'CategoryID');
}

}
