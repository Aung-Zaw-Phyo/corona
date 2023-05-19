@extends('backend.layouts.app')
@section('title', 'Create Admin User')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Create Admin User</h3>
                        <form action="{{ route('admin-user.store') }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control" id="phone">
                            </div>
                            <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" id="email">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="address" cols="30" rows="3"></textarea>
                              </div>
                              <div class="mb-3">
                                <label for="level" class="form-label">Level</label>
                                <select name="level" class="form-select select2" id="level">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="profile" class="form-label">Profile</label>
                                <input type="file" name="profile" class="form-control" id="profile">
                                <div class="preview_img d-flex align-items-start">

                                </div>
                              </div>
                            <div class="mb-3">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <button type="submit" class="btn btn-theme">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreAdminUser', '#create-form') !!}
    <script>
        $(document).ready(function () {
            $('#profile').on('change', function () {
                let profile_img_length = document.getElementById('profile').files.length
                $('.preview_img').html('')
                for (let i = 0; i < profile_img_length; i++) {
                    $('.preview_img').append(`<img width="65" class="m-1" src="${URL.createObjectURL(event.target.files[i])}"/>`)                
                }
            })
        })
    </script>   
@endsection