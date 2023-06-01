<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class PagesController extends Controller
{
    public function home () {
        return view('pages.home');
    }

    public function menu () {
        $menus = Product::with('category')->skip(0)->take(9)->get();
        $categories = Category::all();
        return view('pages.menu', compact('menus', 'categories'));
    }

    public function about () {
        return view('pages.about');
    }

    public function booking () {
        return view('pages.booking');
    }
}
