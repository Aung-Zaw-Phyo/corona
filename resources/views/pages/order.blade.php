@extends('layouts.app')

@section('content')

<div class="hero_area">
    <div class="bg-box">
        <img src="{{ asset('frontend/assets/images/hero-bg.jpg') }}" alt="">
    </div>
    <!-- header section strats -->
    @include('layouts.header_navbar')
    <!-- end header section -->
</div>

<!-- book section -->
<section class="order_section layout_padding">
    <div class="container">
        <h2 class="title text-center mb-3">
            Orders
        </h2>

        <div class="row gap-3">
            @foreach ($orders as $order)
            <div class="col-md-6 col-lg-4 p-2">
                <div class="card order shadow p-3 border-0 h-100">
                    <div class="d-flex justify-content-between">
                        <p><i class="fa-solid fa-calendar-days mr-2 text-secondary"></i> <span>{{ $order->created_at->diffForHumans() }}</span></p>
                        <p><i class="fa-solid fa-money-bill mr-2 text-secondary"></i> <span class="order_status">{{ $order->status }}</span></p>
                    </div>
                    <div class="text-center mb-3">
                        <img width="120" src="{{ asset('frontend/assets/images/deli.jpg') }}" class="gradient-corona-img img-fluid" alt="">
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5 order_lable mb-2">Order Number</div>
                        <div class="col-sm-7 text-secondary mb-2">{{ $order->order_no }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5 order_lable mb-2">Name</div>
                        <div class="col-sm-7 text-secondary mb-2">{{ $order->name }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5 order_lable mb-2">Phone Number</div>
                        <div class="col-sm-7 text-secondary mb-2">{{ $order->phone }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5 order_lable mb-2">Address</div>
                        <div class="col-sm-7 text-secondary mb-2">{{ $order->address }}</div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-5 order_lable mb-2">Message</div>
                        <div class="col-sm-7 text-secondary mb-2">{{ $order->message }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
<!-- end book section -->

@endsection

@section('script')
{!! JsValidator::formRequest('App\Http\Requests\StoreBooking', '#create-form') !!}
<script>
    $(function() {
        $('#datepicker').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "locale": {
                "format": "YYYY-MM-DD",
            },
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
        $('#timepicker').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "minDate": moment().startOf('day').add(8, 'hours'), // Set the minimum start hour (e.g., 8:00 AM)
            "maxDate": moment().startOf('day').add(18, 'hours'), // Set the maximum end hour (e.g., 6:00 PM)
            "timePicker24Hour": true,
            // "timePickerSeconds": true,
            "locale": {
                "format": "HH:mm:ss",
            },
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find('.calendar-table').hide()
        });
    });
</script>
@endsection