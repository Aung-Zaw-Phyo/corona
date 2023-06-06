<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProduct;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index () {
        return view('backend.product.index');
    }

    public function ssd () {
        $products = Product::query();
        return DataTables::of($products)
                ->editColumn('image', function ($each) {
                    return '<div class="menu_img_1"><img src="'. $each->image_path() .'" /></div>';
                })
                ->editColumn('price', function ($each) {
                    return '<span class="badge badge-danger">'. $each->price .' <small>(MMK)</small> </span>';
                })
                ->editColumn('quantity', function ($each) {
                    return '<span class="badge badge-pill badge-primary">'. $each->quantity .'</span>';
                })
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each){
                        $view_btn = '<a href="'. route('product.show', $each->id) .'" class="text-primary"><i class="fa-solid fa-eye text-primary"></i></a>';
                        $edit_btn = '<a href="'. route('product.edit', $each->id) .'" class="text-warning"><i class="fa-solid fa-pen-to-square text-warning"></i></a>';
                        $delete_btn = '<a href="javascript:void(0)" data-id="'. $each->id .'" class="text-danger delete-btn"><i class="fas fa-trash text-danger"></i></a>';
    
                        return '<div class="action-icon">' . $view_btn . $edit_btn . $delete_btn  . '</div>';
                })
                ->addColumn('plus-icon', function($each){
                    return null;
                })
                ->rawColumns(['image', 'price', 'quantity', 'action'])
                ->make(true);
    }

    public function show ($id) {
        $product = Product::findOrFail($id);
        return view('backend.product.show', compact('product'));
    }

    public function create () {
        $categories = Category::all();
        return view('backend.product.create', compact('categories'));
    }

    public function store (StoreProduct $request) {
        $img_name = null;
        if ($request->hasFile('image')) {
            $img_file = $request->file('image');
            $img_name = uniqid() . '_' . time() . '.' .$img_file->getClientOriginalExtension();
            Storage::disk('public')->put('product/' . $img_name, file_get_contents($img_file));
        }

        $product = new Product();
        $product->admin_user_id = auth()->user()->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->image = $img_name;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('product.index')->with('create', 'Product successfully created.');
    }

    public function edit ($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('backend.product.edit', compact('product', 'categories'));
    }

    public function update (UpdateProduct $request, $id) {
        $product = Product::findOrFail($id);

        $img_name = $product->image;
        if ($request->hasFile('profile')) {
            Storage::disk('public')->delete('product/'.$img_name);

            $image_file = $request->file('profile');
            $img_name = uniqid() . '_' . time() . '.' .$image_file->getClientOriginalExtension();
            Storage::disk('public')->put('product/' . $img_name, file_get_contents($image_file));
        }

        $product->admin_user_id = auth()->user()->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->image = $img_name;
        $product->description = $request->description;
        $product->update();

        return redirect()->route('product.index')->with('update', 'Product successfully updated.');
    }

    public function destroy ($id) {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete('product/'.$product->image);
        }
        $product->delete();
        return 'success';
    }

}
