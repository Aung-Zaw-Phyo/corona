@extends('backend.layouts.app')
@section('title', 'Create Product')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Create Product</h3>
                        <form action="{{ route('product.store') }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (MMK)</label>
                                <input type="text" name="price" class="form-control" id="price">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="quantity">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select name="category_id" class="form-select select2" id="category">
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="discount" class="form-label">Discount</label>
                                <select name="discount_id" class="form-select select2" id="discount">
                                    <option value=""></option>
                                    @foreach ($discounts as $discount)
                                        <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                                    @endforeach                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" id="image">
                                <div class="preview_img d-flex align-items-start">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreProduct', '#create-form') !!}
    <script>
        $(document).ready(function () {
            $('#image').on('change', function () {
                let img_length = document.getElementById('image').files.length
                $('.preview_img').html('')
                for (let i = 0; i < img_length; i++) {
                    $('.preview_img').append(`<img width="65" class="m-1" src="${URL.createObjectURL(event.target.files[i])}"/>`)                
                }
            })
        })
    </script>   
@endsection