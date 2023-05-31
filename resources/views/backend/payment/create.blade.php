@extends('backend.layouts.app')
@section('title', 'Create Payment')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Create Payment</h3>
                        <form action="{{ route('payment.store') }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="type" class="form-label">Payment Type</label>
                                <input type="text" name="type" class="form-control" id="type" placeholder="Enter payment type">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter description" cols="30" rows="3"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\StorePayment', '#create-form') !!}
    <script>
        $(document).ready(function () {
            
        })
    </script>   
@endsection