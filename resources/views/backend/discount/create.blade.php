@extends('backend.layouts.app')
@section('title', 'Create Discount')
@section('content')

<div class="row g-2">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body text-dark">
                    <div>
                        <h3 class="mb-3">Create Discount</h3>
                        <form action="{{ route('discount.store') }}" id="create-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter discount name">
                            </div>
                            <div class="mb-3">
                                <label for="percent" class="form-label">Discount Percent</label>
                                <input type="text" name="percent" class="form-control" id="percent" placeholder="Enter discount percent">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="text" name="start_date" class="form-control datepicker" id="start_date">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="text" name="end_date" class="form-control datepicker" id="end_date">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter discount description" cols="30" rows="3"></textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\StoreDiscount', '#create-form') !!}
    <script>
        $(document).ready(function () {
            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }, 
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });
            
        })
    </script>   
@endsection