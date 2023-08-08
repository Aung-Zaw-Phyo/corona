<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    use HttpResponses;

    public function menu (Request $request) {
        $categories = Category::all();
        $products = Product::with('category')->where('status', true)->orderBy('created_at', 'DESC');
        if($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        $products = $products->paginate(8);
        $data = ProductResource::collection($products)->additional(['categories' => $categories, 'status' => true, 'message' => 'Fetched products successfully.']);
        return $data;
    }
}
