<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomer;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateCustomer;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index () {
        return view('backend.customer.index');
    }

    public function ssd () {
        $customers = User::query();
        return DataTables::of($customers)
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each){
                        $view_btn = '<a href="'. route('customer.show', $each->id) .'" class="text-primary"><i class="fa-solid fa-eye text-primary"></i></a>';
                        $edit_btn = '<a href="'. route('customer.edit', $each->id) .'" class="text-warning"><i class="fa-solid fa-pen-to-square text-warning"></i></a>';
                        $delete_btn = '<a href="javascript:void(0)" data-id="'. $each->id .'" class="text-danger delete-btn"><i class="fas fa-trash text-danger"></i></a>';
    
                        return '<div class="action-icon">' . $view_btn . $edit_btn . $delete_btn  . '</div>';
                })
                ->addColumn('plus-icon', function($each){
                    return null;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function show ($id) {
        $customer = User::findOrFail($id);
        return view('backend.customer.show', compact('customer'));
    }

    public function create () {
        return view('backend.customer.create');
    }

    public function store (StoreCustomer $request) {
        $profile_img_name = null;
        if ($request->hasFile('profile')) {
            $profile_img_file = $request->file('profile');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('customer/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $customer = new User();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->profile = $profile_img_name;
        $customer->password = Hash::make($request->password);
        $customer->save();

        return redirect()->route('customer.index')->with('create', 'Customer user successfully created.');
    }

    public function edit ($id) {
        $customer = User::findOrFail($id);
        return view('backend.customer.edit', compact('customer'));
    }

    public function update (UpdateCustomer $request, $id) {
        $customer = User::findOrFail($id);

        $profile_img_name = $customer->profile;
        if ($request->hasFile('profile')) {
            Storage::disk('public')->delete('customer/'.$profile_img_name);

            $profile_img_file = $request->file('profile');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('customer/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->profile = $profile_img_name;
        $customer->password = $request->password ? Hash::make($request->password) : $customer->password;
        $customer->update();

        return redirect()->route('customer.index')->with('update', 'Customer user successfully updated.');
    }

    public function destroy ($id) {
        $customer = User::findOrFail($id);
        $customer->delete();
        return 'success';
    }

}
