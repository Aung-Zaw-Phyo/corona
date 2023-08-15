<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponses;
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|min:9|max:14|unique:users,phone',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), null, 422);
            }


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $user->createToken('myapptoken');
            return $this->success('Successfully Registered.', ['token' => $token->plainTextToken], 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }

    public function login(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), null, 422);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = auth()->user();
                $token = $user->createToken('myapptoken');
                return $this->success('Successfully logged in.', ['token' => $token->plainTextToken], 200);
            }

            return $this->error('Your credentials is not correct.', null, 422);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return $this->success('Successfully logged out.', null, 200);
    }

    public function profile()
    {
        $authUser = auth()->user();
        $user = new ProfileResource($authUser);
        return $this->success('Successfully fetch profile.', ['user' => $user], 200);
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            $id = $user->id;
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|min:11|max:14|unique:users,phone,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'address' => 'nullable',
                'password' => 'nullable',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), null, 422);
            }

            $profile_img_name = $user->profile;
            if ($request->hasFile('profile')) {
                Storage::disk('public')->delete('customer/' . $profile_img_name);

                $profile_img_file = $request->file('profile');
                $profile_img_name = uniqid() . '_' . time() . '.' . $profile_img_file->getClientOriginalExtension();
                Storage::disk('public')->put('customer/' . $profile_img_name, file_get_contents($profile_img_file));
            }

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->profile = $profile_img_name;
            $user->password = $request->password ? Hash::make($request->password) : $user->password;
            $user->update();

            $user = new ProfileResource($user);
            return $this->success('Successfully updated profile.', ['user' => $user], 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }
}
