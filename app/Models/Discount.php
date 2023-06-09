<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    public function products () {
        return $this->belongsToMany(Product::class, 'discount_products', 'discount_id', 'product_id');
    }
}
