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
                    <form method="POST" action="{{ route('register') }}" class="text-light">
                        @csrf
                        <h2 class="mb-3">Login</h2>
                        
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
            
            
            {{-- <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
