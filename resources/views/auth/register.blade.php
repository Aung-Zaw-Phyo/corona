@extends('layouts.app_plain')

@section('extra_css')
    <style>
        .card{
            background: #222831;
            border-radius: 15px;
        }

        input, textarea {
            border: none !important;
            background-color: #333 !important;
            box-shadow: none !important;
            outline: none;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            color: white !important;
            border-radius: 0px !important;
        }

        input:focus, input:hover, textarea:focus, textarea:hover {
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

        .preview_img {
            width: 60px;
            border-radius: 6px;
        }
        
    </style>   
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh" style="overflow: scroll">
        <div class="col-md-8 col-lg-6 py-4">

            <div class="card border-0 p-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="text-light" enctype="multipart/form-data">
                        @csrf
                        <h2 class="mb-3">Register</h2>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" placeholder="Enter your name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" placeholder="Enter your email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" placeholder="Enter your phone">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="profile" class="form-label">Profile </label>
                            <input type="file" name="profile" class="form-control form-control-lg @error('profile') is-invalid @enderror" id="profile" placeholder="Enter your profile">
                            @error('profile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="profile_preview">

                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address </label>
                            <textarea name="address" class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" placeholder="Enter your address" cols="30" rows="5"> {{ old('address') }}</textarea>
                            @error('address')
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
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" id="confirm_password" placeholder="Repeat your password">
                        </div>
                        <button type="submit" class="btn ">Submit</button>

                        <p class="mb-0 mt-3">Already have an account! <a href="/login" class="ms-2">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#profile').on('change', function () {
                $('.profile_preview').html('')
                let file_length = document.getElementById('profile').files.length
                for (let i = 0; i < file_length; i++) {
                    $('.profile_preview').html(`
                        <img class="m-1 preview_img" src="${URL.createObjectURL(event.target.files[i])}" />
                    `)                    
                }
            })
        })
    </script>
@endsection
