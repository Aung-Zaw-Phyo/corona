<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FirebaseNoti;
use App\Helpers\UUIDGenerate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\RegisterUser;
use App\Http\Controllers\Controller;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(RegisterUser $request)
    {
        if(!$request->device_token){
            return redirect()->back()->withErrors(['device_token' => 'something wrong. Please check your internet connection.'])->withInput();
        }

        if(!$request->otp) {
            return redirect()->back()->withErrors(['OTP' => 'Please enter a valid OTP number.'])->withInput();
        }

        $otpDb = Otp::where('device_token', $request->device_token)->orderBy('id', 'DESC')->first();
        if(!$otpDb || $request->otp != $otpDb->otp) {
            return redirect()->back()->withErrors(['OTP' => 'Your OTP number is incorrect.'])->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->device_token = $request->device_token;
        $user->password = Hash::make($request->password);
        $user->save();

        $otps = Otp::where('device_token', $request->device_token)->delete();

        auth()->login($user);

        return redirect('/');
    }

    public function createOTP (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:9|max:14|unique:users,phone',
            'password' => 'required|min:6',
        ]);

        if(!$request->device_token){
            return [
                'status' => 422,
                'message' => 'Something wrong, Please check your internet connection!',
                'data' => null
            ];
        }

        if ( $validator->fails() ) {
            return [
                'status' => 422,
                'message' => $validator->errors()->first(),
                'data' => null
            ];
        }

        $gen_otp = UUIDGenerate::generate_otp();
        $otp = new Otp();
        $otp->device_token = $request->device_token;
        $otp->otp = $gen_otp;
        $otp->save();

        FirebaseNoti::sendNotification($request->device_token, 'Your OTP Number.', $gen_otp);

        return [
            'status' => 201,
            'message' => 'OTP is created successfully!',
            'data' => $request->all()
        ];
    } 


}
