<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index () {
        return view('backend.admin.index');
    }

    public function ssd () {
        $admin_users = AdminUser::query();
        return DataTables::of($admin_users)
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function($each){
                        $view_btn = '<a href="'. route('admin-user.show', $each->id) .'" class="text-primary"><i class="fa-solid fa-eye text-primary"></i></a>';
                        $edit_btn = '<a href="'. route('admin-user.edit', $each->id) .'" class="text-warning"><i class="fa-solid fa-pen-to-square text-warning"></i></a>';
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
        $admin_user = AdminUser::findOrFail($id);
        return view('backend.admin.show', compact('admin_user'));
    }

    public function create () {
        return view('backend.admin.create');
    }

    public function store (StoreAdminUser $request) {
        $profile_img_name = null;
        if ($request->hasFile('profile')) {
            $profile_img_file = $request->file('profile');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('admin/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $admin_user = new AdminUser();
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->address = $request->address;
        $admin_user->level = $request->level;
        $admin_user->profile = $profile_img_name;
        $admin_user->password = Hash::make($request->password);
        $admin_user->save();

        return redirect()->route('admin-user.index')->with('create', 'Admin user successfully created.');
    }

    public function edit ($id) {
        $admin_user = AdminUser::findOrFail($id);
        return view('backend.admin.edit', compact('admin_user'));
    }

    public function update (UpdateAdminUser $request, $id) {
        $admin_user = AdminUser::findOrFail($id);

        $profile_img_name = $admin_user->profile;
        if ($request->hasFile('profile')) {
            Storage::disk('public')->delete('admin/'.$profile_img_name);

            $profile_img_file = $request->file('profile');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('admin/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->address = $request->address;
        $admin_user->level = $request->level;
        $admin_user->profile = $profile_img_name;
        $admin_user->password = $request->password ? Hash::make($request->password) : $admin_user->password;
        $admin_user->update();

        return redirect()->route('admin-user.index')->with('update', 'Admin user successfully updated.');
    }

    public function destroy ($id) {
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->delete();
        return 'success';
    }

}
