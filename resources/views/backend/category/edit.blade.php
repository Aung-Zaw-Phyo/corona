@extends('backend.layouts.app')
@section('title', 'Edit Catetgory')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Edit Category</h3>
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                        <form action="{{ route('category.update', $category->id) }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" id="name" placeholder="Enter category name">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter category description" cols="30" rows="3">{{ old('description', $category->description) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-theme">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCategory', '#create-form') !!}
    <script>
        
    </script>   
@endsection