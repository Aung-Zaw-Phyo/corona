<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    use HttpResponses;
    public function register (Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|min:9|max:14|unique:users,phone',
                'password' => 'required|min:6',
            ]);

            if($validator->fails()) {
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

    public function login (Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if($validator->fails()) {
                return $this->error($validator->errors()->first(), null, 422);
            }

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = auth()->user();
                $token = $user->createToken('myapptoken');
                return $this->success('Successfully logged in.', ['token' => $token->plainTextToken], 200);
            }
            
            return $this->error('Your credentials is not correct.', null, 422);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }

        
    }

    public function logout () {
        $user = auth()->user();
        $user->tokens()->delete();
        return $this->success('Successfully logged out.', null, 200);
    }

    public function profile () {
        // if(!auth()->user()->tokenCan('user:list')){
        //     return response()->json([
        //         'status' => 403,
        //         'message' => 'Unauthorized!',
        //     ]);
        // }

        $authUser = auth()->user();
        $user = new ProfileResource($authUser);
        return $this->success('Successfully fetch profile.', ['user' => $user], 200);
    }
    
    public function userList () {
        $users = User::all();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully fetch all users.',
            'data' => $users
        ]);
    }
}
