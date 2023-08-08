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
<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Book A Table
            </h2>
        </div>
        <div class="form_container mb-6">
            <form action="/booking" method="POST" id="create-form">
                @csrf
                <div class="alert-message">
                    @if ($errors->first())
                        <div class="alert alert-warning text-center">{{ $errors->first() }}</div>
                    @endif
                </div>
                <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control mb-1" placeholder="Your Name" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control mb-1" placeholder="Phone Number" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-1" placeholder="Your Email" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="persons" class="form-label">Persons</label>
                            <select name="person" class="form-control mb-1 nice-select wide">
                                <option disabled selected>
                                    How many persons?
                                </option>
                                <option value="1">
                                    1
                                </option>
                                <option value="2">
                                    2
                                </option>
                                <option value="3">
                                    3
                                </option>
                                <option value="4">
                                    4
                                </option>
                                <option value="5">
                                    5
                                </option>
                                <option value="6">
                                    6
                                </option>
                                <option value="7">
                                    7
                                </option>
                                <option value="8">
                                    8
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="text" id="datepicker" class="form-control mb-1" name="date" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Time</label>
                            <input type="text" id="timepicker" class="form-control mb-1" name="time">
                        </div>
                </div>
                <div class="btn_box flex justify-content-end">
                    <button>
                        Book Now
                    </button>
                </div>
            </form>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="map_container ">
                    <div id="googleMap"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="heading_container">
                    <h2 class="mb-3">
                        Welcome To Our Restaurant
                    </h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus sit, excepturi debitis fugit optio ut cupiditate qui provident vitae ipsa, nobis minus praesentium maxime deserunt illum eos nemo deleniti vel!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus sit, excepturi debitis fugit optio ut cupiditate qui provident vitae ipsa.
                    </p>
                </div>
            </div>

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