<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discount;

class HomeController extends Controller
{
    public function home () {
        $categories = Category::all();
        $discounts = Discount::where('status', true)->get();
        return view('pages.home', compact('categories', 'discounts'));
    }
}
