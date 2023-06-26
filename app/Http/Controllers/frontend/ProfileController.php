<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileInfo;

class ProfileController extends Controller
{
    public function index () {
        $user = auth()->user();
        return view('pages.profile', compact('user'));
    }

    public function updateInfo (UpdateProfileInfo $request, $id) {
        $user = auth()->user();
        if($id != $user->id) {
            abort(403);
        }

        $profile_img_name = $user->profile;
        if ($request->hasFile('profile')) {
            Storage::disk('public')->delete('customer/'.$profile_img_name);

            $profile_img_file = $request->file('profile');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('customer/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->profile = $profile_img_name;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->update();
        return redirect()->back()->with('update', 'Successfully updated.');
    }
}
