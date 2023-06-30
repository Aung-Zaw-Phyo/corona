@extends('layouts.app_plain')

@section('extra_css')
    <style>
        .card{
            background: #222831;
            border-radius: 15px;
        }

        input {
            border: none !important;
            background-color: #333 !important;
            box-shadow: none !important;
            outline: none;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            color: white !important;
            border-radius: 0px !important;
        }

        input:focus, input:hover {
            box-shadow: none !important;
            outline: none !important;
            border: none !important;
        }

        .btn {
            background-color: #ffbe33;
            width: 130px;
            height: 48px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            border-radius: 0px !important;
            border: none !important;
        }

        .btn:hover, .btn:focus {
            background-color: #ffbe33 !important;
            border: none !important;
        }

        a , a:hover , a:focus {
            color: #ffbe33 !important;
        }
        
    </style>   
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-8 col-lg-6">
            
            <div class="card border-0 p-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="text-light">
                        @csrf
                        <h2 class="mb-3">Login</h2>
                        <input type="text" name="device_token" class="form-control form-control-lg" placeholder="Device Token" id="device_token_input" hidden>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"  value="{{ old('email') }}" id="email" placeholder="Enter your email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="Enter your password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn ">Submit</button>
                        
                        <p class="mb-0 mt-3">You don't have an account! <a href="/register" class="ms-2">Register</a></p>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
