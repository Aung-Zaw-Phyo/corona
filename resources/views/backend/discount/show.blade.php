@extends('backend.layouts.app')
@section('title', 'View Discount')
@section('content')
    <div class="show_discount row g-2">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <p><h4>{{ $discount->name }}</h4></p>
                    <p>
                        <span><span class="text-muted"><i class="fa-solid fa-calendar-days"></i> Start Date</span> : <span class="badge badge-warning">{{ $discount->start_date }}</span></span> |
                        <span><span class="text-muted"><i class="fa-solid fa-calendar-days"></i> End Date</span> : <span class="badge badge-warning">{{ $discount->end_date }}</span></span>
                    </p>
                    <p><span class="text-muted"><i class="fa-solid fa-percent"></i> Discount Percent</span> : <span class="badge badge-primary">{{ $discount->percent }}</span></p>
                    <p>
                        <p><h5>Description</h5></p>
                        {{ $discount->description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <p><h4>Discounted Products</h4></p>
                    <div class="row g-2">
                        @foreach ($discount->products as $product)
                            <div class="col-lg-6">
                                <div class="card discounted_product_card">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <img src="{{ $product->image_path() }}" alt="">
                                        </div>
                                        <p class="mb-2">{{ $product->name }}</p>
                                        <p class="mb-1">
                                            <span class="badge badge-danger">{{ $product->price }} MMK</span>
                                            <span class="badge badge-primary">{{ $product->quantity }} </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection