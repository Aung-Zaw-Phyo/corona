@extends('backend.layouts.app')
@section('title', 'View Admin User')
@section('content')
    <div class="admin_user_show">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3">
                            @if ($admin_user->profile_img_path())
                                <img src="{{ $admin_user->profile_img_path() }}" alt="">
                            @else
                                <img src="https://ui-avatars.com/api/?background=ffbe33&color=191C24&name={{ $admin_user->name }}" alt="">
                            @endif
                        </div>
                        <p>Name : <span class="text-muted">{{ $admin_user->name }}</span></p>
                        <p> Ispresent :
                            @if ($admin_user->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-6 dotted_left_border d-flex flex-column justify-content-center align-items-start">
                        <div>
                            <p>
                                Name : <span class="text-muted">{{ $admin_user->name }}</span>
                            </p>
                            <p>
                                Email : <span class="text-muted">{{ $admin_user->email }}</span>
                            </p>
                            <p>
                                Phone : <span class="text-muted">{{ $admin_user->phone }}</span>
                            </p>
                            <p>
                                Level : 
                                <span class="text-muted">
                                    @if ($admin_user->level == 1)
                                        <span class="badge badge-success">Admin</span>
                                    @else
                                        <span class="badge badge-danger">Assistant</span>
                                    @endif
                                </span>
                            </p>
                            <p>
                                Address : <span class="text-muted">{{ $admin_user->address }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection