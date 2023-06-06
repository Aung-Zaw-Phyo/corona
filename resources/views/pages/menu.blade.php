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

  <!-- food section -->

  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Menu
        </h2>
      </div>

      <ul class="filters_menu">
        <li class="active category" data-id="">All</li>
        @foreach ($categories as $category)
          <li data-id="{{ $category->id }}" class="category">{{ $category->name }}</li>
        @endforeach
      </ul>

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
        $(document).ready(function () {
            
            let page = 1;
            let category_id = '';
            function get_menu () {
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

            $('#view_more').on('click', function (e) {
              e.preventDefault()
              page ++
              get_menu()
            })

            $('.category').on('click', function (e) {
              e.preventDefault()
              page = 1
              category_id = $(this).data('id')
              document.querySelector('#menu_data').innerHTML = ''
              get_menu()
            })

            // ----------- Add To Cart ---------------

            $(document).on('click', '.add_to_cart', function (e) {
              e.preventDefault()
              let product = JSON.parse(atob($(this).data('product')));
              let id = product.id;
              let price = product.price;
              let name = product.name;
              let discount = product.discount;
              $.ajax({
                  url: `/menu/cart`,
                  method: 'POST',
                  data: {"id": id, "price": price, "name": name, "discount": discount},
                  success: (res) => {
                    if(res.status == 200) {
                      Swal.fire({
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'Containue'
                      })
                      cart()
                    }else if (res.status === 401) {
                      Swal.fire({
                        icon: 'info',
                        text: res.message,
                        confirmButtonText: 'Login',
                      }).then((result) => {
                        if (result.isConfirmed) {
                          window.location.href = '/login'
                        } 
                      })
                    }else {
                      Swal.fire({
                        text: res.message,
                        icon: 'error',
                        confirmButtonText: 'Containue'
                      })
                    }
                  }
              })
            })

            const cart = function () {
              $.ajax({
                  url: `/menu-cart`,
                  method: 'GET',
                  success: (res) => {
                    $('.cart_layout').html(res)
                  }
              })
            }

            
        })
    </script>
@endsection