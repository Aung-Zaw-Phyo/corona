@extends('backend.layouts.app')
@section('title', 'Create Category')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Create Category</h3>
                        <form action="{{ route('category.store') }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter category name">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter category description" cols="30" rows="3"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreCategory', '#create-form') !!}
    <script>
        $(document).ready(function () {
            
        })
    </script>   
@endsection