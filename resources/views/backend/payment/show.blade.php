@extends('backend.layouts.app')
@section('title', 'View Customer')
@section('content')
    <div class="admin_user_show">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3">
                            @if ($customer->profile_img_path())
                                <img src="{{ $customer->profile_img_path() }}" alt="">
                            @else
                                <img src="https://ui-avatars.com/api/?background=ffbe33&color=191C24&name={{ $customer->name }}" alt="">
                            @endif
                        </div>
                        <p>Name : <span class="text-muted">{{ $customer->name }}</span></p>
                        <p> Ispresent :
                            @if ($customer->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-6 dotted_left_border d-flex flex-column justify-content-center align-items-start">
                        <div>
                            <p>
                                Name : <span class="text-muted">{{ $customer->name }}</span>
                            </p>
                            <p>
                                Email : <span class="text-muted">{{ $customer->email }}</span>
                            </p>
                            <p>
                                Phone : <span class="text-muted">{{ $customer->phone }}</span>
                            </p>
                            <p>
                                Address : <span class="text-muted">{{ $customer->address }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection