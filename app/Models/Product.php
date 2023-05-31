<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    public function image_path () {
        if($this->image){
            return asset('storage/product/'.$this->image);
        }
        return null;
    }

    public function discount () {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    public function category () {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
