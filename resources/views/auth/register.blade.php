@extends('layouts.app_plain')

@section('extra_css')
    <style>
        .card{
            background: #222831;
            border-radius: 0 !important;
        }
        .alert{
            border-radius: 0 !important;
        }
        #register input, #register textarea, .otp-input {
            border: none !important;
            background-color: #333 !important;
            box-shadow: none !important;
            outline: none;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            color: white !important;
            border-radius: 0px !important;
        }

        #register input:focus, #register input:hover, #register textarea:focus, #register textarea:hover, .otp-input {
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

        .invalid-feedback {
            font-size: 15px !important;
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100vh;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 99;
            background: #333333eb;

        }

        .otp-input {
            background-color: #ddd !important;
            color: black !important;
            font-size: 18px;
        }

        .form-container {
            z-index: 999;

        }

        .btn.disabled{
            background-color: #ffbe33;
        }

        .cancel {
            position: absolute;
            top: 0px;
            right: 0px;
            background: red;
            color: white;
            text-align: center;
            font-size: 30px;
            width: 35px;
            height: 32px;
            cursor: pointer;
        }
        
    </style>   
@endsection

@section('content')
<div class="overlay d-none d-flex justify-content-center align-items-center" id="overlay">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6 mx-auto py-3 form-container" id="form-container">
                <div class="card bg-light border-0 p-2 px-3 position-relative">
                    <div class="card-body">
                        <i class="fa-solid fa-xmark cancel" ></i>
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-3" id="request-form">
                            @csrf
                            <div id="hidden-inputs">
                                
                            </div>
                            <h4>OTP Number</h4>
                            <div class="mb-3">
                                <input type="text" name="otp" class="otp-input p-2 w-100" placeholder="Enter your OTP number">
                            </div>
                            <button  type="submit" class="btn w-100 text-light disabled" id="request-form-btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh" style="overflow: scroll">
        <div class="col-md-8 col-lg-6 py-3">

            <div class="card border-0 p-2 px-3 ">
                <div class="card-body ">
                    <form class="text-light" enctype="multipart/form-data" id="register">
                        @csrf
                        <h2 class="mb-3">Register</h2>

                        <div class="alert-message">
                            @if ($errors->first())
                                <div class="alert alert-warning">{{ $errors->first() }}</div>
                            @endif
                        </div>

                        <input type="hidden" class="form-control" name="device_token" id="device_token_input">

                        <div class="mb-2">
                            <label for="name" class="form-label">Name </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" placeholder="Enter your name">
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-2">
                            <label for="phone" class="form-label">Phone </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" placeholder="Enter your phone">
                        </div>
                        <div class="mb-2">
                            <label for="address" class="form-label">Address </label>
                            <textarea name="address" class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" placeholder="Enter your address" cols="30" rows="2"> {{ old('address') }}</textarea>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="Enter your password">
                        </div>
                        <button type="submit" class="btn w-100 mt-2 register-btn">Submit</button>

                        <p class="mb-0 mt-3">Already have an account! <a href="/login" class="ms-2">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\RegisterUser', '#register') !!}
    <script>
        $(document).ready(function () {

            $('#register').on('submit', function (e) {
                e.preventDefault()
                if($('input.form-control.is-valid').length === 4) {
                    $('.register-btn').addClass('disabled')
                    let formData = new FormData($('#register')[0]);
                    $.ajax({
                    url: `/create-otp`,
                    method: 'POST',
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        console.log(res)
                        if(res.status == 201) {
                            const user = res.data
                            $('#hidden-inputs').html(`
                                <input type="hidden" name="device_token" value='${user.device_token}'>
                                <input type="hidden" name="name" value='${user.name}'>
                                <input type="hidden" name="email"placeholder="Enter your email" value='${user.email}'>
                                <input type="hidden" name="phone" value='${user.phone}'>
                                <textarea name="address" cols="30" rows="2" hidden>${user.address}</textarea>
                                <input type="hidden"  name="password" value='${user.password}'>
                            `)
                            $('.overlay').removeClass('d-none')
                        }else {
                            $('.alert-message').html(`
                                <div class="alert alert-warning">${res.message}</div>
                            `)
                        }
                        $('.register-btn').removeClass('disabled')
                    }
                })

                }
            })

            // $('.overlay').on('click', function (event) {
            //     if(!document.getElementById('form-container').contains(event.target)){
            //         $('.overlay').toggleClass('d-none')
            //     }
                
            // })

            $('.cancel').on('click', function () {
                $('.overlay').addClass('d-none');
            })

            document.getElementsByClassName('otp-input')[0].addEventListener('keyup', (event) => {
                let value = event.target.value;
                if(value.length === 6) {
                    $('#request-form-btn').removeClass('disabled')
                }else {
                    $('#request-form-btn').addClass('disabled')
                }
            })


        })
    </script>
@endsection
