<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function menu () {
        $categories = Category::all();
        return view('pages.menu', compact('categories'));
    }

    public function menuGet (Request $request) {
        $skip_count = 0;
        $products = Product::with('category');
        if($request->category){
            $products = $products->where('category_id', $request->category);
        }
        if($request->page > 1){
            $skip_count = ($request->page * 6) - 6;
        }
        $products = $products->skip($skip_count)->take(6)->get();
        return view('pages.components.menu', compact('products'))->render();
    }

    public function createCart (Request $request) {
        if (!Auth::check()) {
            return [
                'status' => 401,
                'message' => 'Please Login!',
                'data' => null
            ];
        }

        $checkItem = OrderItem::where('user_id', auth()->user()->id)->where('product_id', $request->id)->where('status', true)->exists();
        if($checkItem){
            return [
                'status' => 422,
                'message' => "$request->name is already added to cart.",
                'data' => null
            ];
        }

        $order_item = new OrderItem();
        $order_item->user_id = auth()->user()->id;
        $order_item->product_id = $request->id;
        $order_item->quantity = 1;
        $order_item->total_price = $request->price;
        $order_item->save();

        return [
            'status' => 200,
            'message' => "$request->name is successfully added to cart.",
            'data' => null
        ];
    }

    public function removeCart (Request $request) {
        $order_item = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('id', $request->cart_id)->firstOrFail();
        $order_item->delete();
        return [
            'status' => 200,
            'message' => $order_item->product->name . " is successfully removed from cart.",
            'data' => null
        ];
    } 

    public function menuCart () {
        $carts = [];
        if(Auth::check()){
            $carts = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', true)->get();
        }
        return view('pages.components.cart', compact('carts'))->render();
    }

}
