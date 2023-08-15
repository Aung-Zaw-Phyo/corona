<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    public function product () {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user () {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
