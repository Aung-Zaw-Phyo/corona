<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;

class CategoryController extends Controller
{
    public function index () {
        return view('backend.category.index');
    }

    public function ssd () {
        $categories = Category::query();
        return DataTables::of($categories)
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each){
                        // $view_btn = '<a href="'. route('category.show', $each->id) .'" class="text-primary"><i class="fa-solid fa-eye text-primary"></i></a>';
                        $edit_btn = '<a href="'. route('category.edit', $each->id) .'" class="text-warning"><i class="fa-solid fa-pen-to-square text-warning"></i></a>';
                        $delete_btn = '<a href="javascript:void(0)" data-id="'. $each->id .'" class="text-danger delete-btn"><i class="fas fa-trash text-danger"></i></a>';
    
                        return '<div class="action-icon">' . $edit_btn . $delete_btn  . '</div>';
                })
                ->addColumn('plus-icon', function($each){
                    return null;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    // public function show ($id) {
    //     $category = User::findOrFail($id);
    //     return view('backend.category.show', compact('category'));
    // }

    public function create () {
        return view('backend.category.create');
    }

    public function store (StoreCategory $request) {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('category.index')->with('create', 'Category successfully created.');
    }

    public function edit ($id) {
        $category = Category::findOrFail($id);
        return view('backend.category.edit', compact('category'));
    }

    public function update (UpdateCategory $request, $id) {
        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->update();

        return redirect()->route('category.index')->with('update', 'Category successfully updated.');
    }

    public function destroy ($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return 'success';
    }

}
