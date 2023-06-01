@extends('backend.layouts.app')
@section('title', 'Edit Payment')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Edit Payment</h3>
                        <form action="{{ route('payment.update', $payment->id) }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="type" class="form-label">Payment Type</label>
                                <input type="text" name="type" class="form-control" id="type" placeholder="Enter payment type" value="{{ old('type', $payment->type) }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter description" cols="30" rows="5">{{ old('description', $payment->description) }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePayment', '#create-form') !!}
    <script>
        $(document).ready(function () {
            
        })
    </script>   
@endsection