<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\StoreDiscount;
use App\Http\Requests\UpdateCategory;
use App\Http\Requests\UpdateDiscount;
use Illuminate\Cache\RateLimiting\Limit;

class DiscountController extends Controller
{
    public function index () {
        return view('backend.discount.index');
    }

    public function ssd () {
        $categories = Discount::query();
        return DataTables::of($categories)
                ->editColumn('percent', function ($each) {
                    return '<span class="badge badge-primary fw-bold">'. $each->percent .' <i class="fa-solid fa-percent"></i></span>';
                })
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each){
                        $view_btn = '<a href="'. route('discount.show', $each->id) .'" class="text-primary"><i class="fa-solid fa-eye text-primary"></i></a>';
                        $edit_btn = '<a href="'. route('discount.edit', $each->id) .'" class="text-warning"><i class="fa-solid fa-pen-to-square text-warning"></i></a>';
                        $delete_btn = '<a href="javascript:void(0)" data-id="'. $each->id .'" class="text-danger delete-btn"><i class="fas fa-trash text-danger"></i></a>';
    
                        return '<div class="action-icon">' . $view_btn . $edit_btn . $delete_btn  . '</div>';
                })
                ->addColumn('plus-icon', function($each){
                    return null;
                })
                ->rawColumns(['percent', 'action'])
                ->make(true);
    }

    public function show ($id) {
        $discount = Discount::with('products')->findOrFail($id);
        return view('backend.discount.show', compact('discount'));
    }

    public function create () {
        return view('backend.discount.create');
    }

    public function store (StoreDiscount $request) {
        $discount = new Discount();
        $discount->admin_user_id = auth()->user()->id;
        $discount->name = $request->name;
        $discount->percent = $request->percent;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->description = $request->description;
        $discount->save();

        return redirect()->route('discount.index')->with('create', 'Discount successfully created.');
    }

    public function edit ($id) {
        $discount = Discount::findOrFail($id);
        return view('backend.discount.edit', compact('discount'));
    }

    public function update (UpdateDiscount $request, $id) {
        $discount = Discount::findOrFail($id);

        $discount->name = $request->name;
        $discount->percent = $request->percent;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->description = $request->description;
        $discount->update();

        return redirect()->route('discount.index')->with('update', 'Discount successfully updated.');
    }

    public function destroy ($id) {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return 'success';
    }

}
