@extends('backend.layouts.app')
@section('title', 'View Product')
@section('content')
    <div class="product_show">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center">
                        <div class="mb-3">
                            <img src="{{ $product->image_path() }}" alt="">
                        </div>
                        <span class="badge badge-success">{{ $product->name }}</span></p>
                    </div>
                    <div class="col-lg-6 dotted_left_border d-flex flex-column justify-content-center align-items-start">
                        <div>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Price</th>
                                        <td><span class="badge badge-danger">{{ $product->price }} (MMK)</span></td>
                                    </tr>
                                    <tr>
                                        <th>Quntity</th>
                                        <td><span class="badge badge-primary">{{ $product->quantity }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>{{ $product->category ? $product->category->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td>{{ $product->discount ? $product->discount->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $product->description ? $product->description : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection