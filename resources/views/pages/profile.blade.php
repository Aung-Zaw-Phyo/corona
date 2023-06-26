@extends('layouts.app')

@section('content')

@section('extra_css')
    <style>
        .header_section {
            background-color: #222831;
        }

        .hero_area {
            min-height: auto;
        }

        textarea {
            height: 80px !important;
        }
    </style>
@endsection

<div class="hero_area">
    @include('layouts.header_navbar')
  </div>

    <div class="container py-5 profile">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3 profile_img">
                            @if ($user->profile_img_path())
                                <img src="{{ $user->profile_img_path() }}" alt="">
                            @else
                                <img src="https://ui-avatars.com/api/?background=ffbe33&color=191C24&name={{ $user->name }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 dotted_left_border profile_info d-flex flex-column justify-content-center align-items-start">
                        <div>
                            <p>
                                Name : <span class="text-muted ml-2">{{ $user->name }}</span>
                            </p>
                            <p>
                                Email : <span class="text-muted ml-2">{{ $user->email }}</span>
                            </p>
                            <p>
                                Phone : <span class="text-muted ml-2">{{ $user->phone }}</span>
                            </p>
                            <p>
                                Address : <span class="text-muted ml-2">{{ $user->address }}</span>
                            </p>
                            <p>
                                <button id="show_update_information_section"><i class="fa-sharp fa-solid fa-pen-to-square mr-2"></i> Edit Your Info</button>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row update_information_section d-none">
                    <div class="col-12">
                        <div class="form_container">
                            <form action="{{ route('pages.updateProfileInfo', $user->id) }}" method="POST" id="update-form" enctype="multipart/form-data">
                                @csrf
                              <div class="mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name', $user->name) }}" />
                              </div>
                              <div class="mb-3">
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number" value='{{ old('phone', $user->phone) }}'/>
                              </div>
                              <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Your Email"  value='{{ old('email', $user->email) }}'/>
                              </div>
                              <div class="mb-3">
                                <input type="file" name="profile" class="form-control" id="profile">
                                <div class="preview_img d-flex align-items-start">
                                    
                                </div>
                              </div>
                              <div class="mb-3">
                                <textarea class="form-control" name="address" id="" cols="30" rows="10" placeholder="Enter address">{{ old('address', $user->address) }}</textarea>
                              </div>
                              <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Your password"/>
                              </div>
                              <div class="btn_box d-flex justify-content-end">
                                <button type="submit">
                                  Confirm
                                </button>
                              </div>
                            </form>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateProfileInfo', '#update-form') !!}
    <script>
        $(document).ready(function () {
            $('#profile').on('change', function () {
                let profile_img_length = document.getElementById('profile').files.length
                $('.preview_img').html('')
                for (let i = 0; i < profile_img_length; i++) {
                    $('.preview_img').append(`<img width="65px" class="m-1" src="${URL.createObjectURL(event.target.files[i])}"/>`)                
                }
            })
            $('#show_update_information_section').on('click', function() {
                $('.update_information_section').toggleClass( "d-none")
            })
        })
    </script>
@endsection