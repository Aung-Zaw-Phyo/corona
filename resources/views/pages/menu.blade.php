@extends('layouts.app')

@section('extra_css')
<style>
    .form-control {
        margin-bottom: 25px;
        outline: none;
        -webkit-box-shadow: none;
        box-shadow: none;
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #222831 !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }

    .btn:hover,
    .btn:focus {
        text-decoration: none !important;
    }
</style>
@endsection

@section('content')

<div class="hero_area">
    <div class="bg-box">
        <img src="{{ asset('frontend/assets/images/hero-bg.jpg') }}" alt="">
    </div>
    <!-- header section strats -->
    @include('layouts.header_navbar')
    <!-- end header section -->
</div>

<!-- food section -->

<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Our Menu
            </h2>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <ul class="filters_menu justify-content-start" style="margin-top: 20px;">
                <li class="active category" data-id="">All</li>
                @foreach ($categories as $category)
                <li data-id="{{ $category->id }}" class="category">{{ $category->name }}</li>
                @endforeach
            </ul>
            <div class="">
                <div class="input-group">
                    <input type="text" class="form-control" id='search-input' placeholder="Search menu">
                    <div class="input-group-append">
                        <button class="btn btn-outline-dark" type="button" id="search-btn">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="filters-content">
            <div class="row g-2" id="menu_data">

            </div>
        </div>
        <div class="btn-box">
            <a href="" id="view_more">
                View More
            </a>
        </div>
    </div>
</section>

<!-- end food section -->

@endsection

@section('script')
<script>
    $(document).ready(function() {

        let page = 1;
        let category_id = '';

        function get_menu() {
            let url = category_id === '' ? `/menu-get?page=${page}` : `/menu-get?page=${page}&category=${category_id}`
            $.ajax({
                url: url,
                method: 'GET',
                success: (res) => {
                    document.querySelector('#menu_data').innerHTML += res
                }
            })
        }

        get_menu()

        $('#view_more').on('click', function(e) {
            e.preventDefault()
            page++
            get_menu()
        })

        $('.category').on('click', function(e) {
            $('#search-input').val('')
            e.preventDefault()
            page = 1
            category_id = $(this).data('id')
            document.querySelector('#menu_data').innerHTML = ''
            get_menu()
        })

        // ----------- Add To Cart ---------------

        $(document).on('click', '.add_to_cart', function(e) {
            e.preventDefault()
            let product = JSON.parse(atob($(this).data('product')));
            let id = product.id;
            let price = product.price;
            let name = product.name;
            let discount = product.discount;
            $.ajax({
                url: `/menu/cart`,
                method: 'POST',
                data: {
                    "id": id,
                    "price": price,
                    "name": name,
                    "discount": discount
                },
                success: (res) => {
                    if (res.status == 200) {
                        Swal.fire({
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'Containue'
                        })
                        cart()
                    } else if (res.status === 401) {
                        Swal.fire({
                            icon: 'info',
                            text: res.message,
                            confirmButtonText: 'Login',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/login'
                            }
                        })
                    } else {
                        Swal.fire({
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'Containue'
                        })
                    }
                }
            })
        })

        const cart = function() {
            $.ajax({
                url: `/menu-cart`,
                method: 'GET',
                success: (res) => {
                    $('.cart_layout #carts').html(res)
                }
            })
        }

        const searchFeature = () => {
            let search = $('#search-input').val()
            if (search.trim() === '') {
                return
            }
            $('.category').removeClass('active')
            category_id = '';
            let url = `/menu-get?page=${page}&search=${search}`;
            $.ajax({
                url: url,
                method: 'GET',
                success: (res) => {
                    document.querySelector('#menu_data').innerHTML = res
                }
            })
        }

        $('#search-btn').on('click', function() {
            searchFeature()
        })
        $('#search-input').on('keypress', function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                searchFeature()
            }
        })
    })
</script>
@endsection