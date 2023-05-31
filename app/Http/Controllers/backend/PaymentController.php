<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StorePayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdatePayment;
use App\Http\Requests\UpdateCategory;

class PaymentController extends Controller
{
    public function index () {
        return view('backend.payment.index');
    }

    public function ssd () {
        $categories = Payment::query();
        return DataTables::of($categories)
                ->editColumn('description', function ($each) {
                    return $each->description ? Str::limit($each->description, 100) : '-';
                })
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each){
                        // $view_btn = '<a href="'. route('payment.show', $each->id) .'" class="text-primary"><i class="fa-solid fa-eye text-primary"></i></a>';
                        $edit_btn = '<a href="'. route('payment.edit', $each->id) .'" class="text-warning"><i class="fa-solid fa-pen-to-square text-warning"></i></a>';
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
    //     $payment = User::findOrFail($id);
    //     return view('backend.payment.show', compact('payment'));
    // }

    public function create () {
        return view('backend.payment.create');
    }

    public function store (StorePayment $request) {
        $payment = new Payment();
        $payment->type = $request->type;
        $payment->description = $request->description;
        $payment->save();

        return redirect()->route('payment.index')->with('create', 'Payment successfully created.');
    }

    public function edit ($id) {
        $payment = Payment::findOrFail($id);
        return view('backend.payment.edit', compact('payment'));
    }

    public function update (UpdatePayment $request, $id) {
        $payment = Payment::findOrFail($id);

        $payment->type = $request->type;
        $payment->description = $request->description;
        $payment->update();

        return redirect()->route('payment.index')->with('update', 'Payment successfully updated.');
    }

    public function destroy ($id) {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return 'success';
    }

}
