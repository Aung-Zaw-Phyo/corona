@extends('layouts.app_plain')

@section('extra_css')
    <style>
        .check {
            font-size: 80px;
            color: #333333de;
            margin-bottom: 30px;
        }
        a{
            color: #333333de;
            font-size: 20px
        }
    </style>
@endsection
    
@section('content')
    <div class="container py-5">
        <div class="col-md-10 col-lg-8 col-xl-6 mx-auto p-3">
            <div class="card p-3 py-5 shadow border-0 rounded-3 text-center">
                <i class="fa-regular fa-circle-check check"></i>
                <h2 class="mb-3">Payment has been successfully done.</h2>
                <h4 class="mb-3">Thank you so much for your purchase</h4>
                <div>
                    <a href="/">GO HOME</a>
                </div>
            </div>
        </div>
    </div>
@endsection