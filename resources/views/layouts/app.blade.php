
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/favicon.png" type="">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title> Corona </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/bootstrap.css') }}" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom styles for this template -->
  <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('css/pages.css') }}">

  @yield('extra_css')

</head>
<body class="user_panel">

        <div class="cart_layout">
            <div class="position-relative h-100">
              <h4 class="text-center text-light title">Your Carts</h4>
              <div id="carts">

              </div>
              <div class="checkout-action">
                <a href="/checkout">CHECKOUT</a>
              </div>
            </div>
        </div>

        @yield('content')

        <footer class="footer_section">
          <div class="container">
            <div class="row">
              <div class="col-md-4 footer-col">
                <div class="footer_contact">
                  <h4>
                    Contact Us
                  </h4>
                  <div class="contact_link_box">
                    <a href="">
                      <i class="fa fa-map-marker" aria-hidden="true"></i>
                      <span>
                        Location
                      </span>
                    </a>
                    <a href="">
                      <i class="fa fa-phone" aria-hidden="true"></i>
                      <span>
                        Call +01 1234567890
                      </span>
                    </a>
                    <a href="">
                      <i class="fa fa-envelope" aria-hidden="true"></i>
                      <span>
                        demo@gmail.com
                      </span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 footer-col">
                <div class="footer_detail">
                  <a href="" class="footer-logo">
                    Corona
                  </a>
                  <p>
                    Necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with
                  </p>
                  <div class="footer_social">
                    <a href="">
                      <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="">
                      <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="">
                      <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </a>
                    <a href="">
                      <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="">
                      <i class="fa fa-pinterest" aria-hidden="true"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4 footer-col">
                <h4>
                  Opening Hours
                </h4>
                <p>
                  Everyday
                </p>
                <p>
                  10.00 Am -10.00 Pm
                </p>
              </div>
            </div>
            <div class="footer-info">
              <p>
                &copy; <span id="displayYear"></span> All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a><br><br>
                &copy; <span id="displayYear"></span> Distributed By
                <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
              </p>
            </div>
          </div>
        </footer>

<!-- jQery -->
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>

<!-- popper js -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<!-- bootstrap js -->
<script src="{{ asset('frontend/assets/js/bootstrap.js') }}"></script>
<!-- owl slider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!-- isotope js -->
<script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
<!-- nice select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<!-- custom js -->
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
<!-- Google Map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
<!-- End Google Map -->

{{-- Sweet alert 2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Sweet alert 1 --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

  @yield('script')
<script>
    $(document).ready(function () {
          let token = document.querySelector('meta[name=csrf-token]')
          if(token) {
              $.ajaxSetup({
                  headers: { 
                      'X-CSRF-TOKEN': token.content
                  }
              });
          }else {
              console.error('Token not found!');
          }

        $(document).on('click', '#cart', function (e) {
          e.preventDefault()
          $('.cart_layout').toggleClass('cart_layout_hide_show')
        })

        const cart = function () {
          $.ajax({
              url: `/menu-cart`,
              method: 'GET',
              success: (res) => {
                $('.cart_layout #carts').html(res)
              }
          })
        }

        cart()

        $(document).on('click', '.remove_cart', function(e) {
          e.preventDefault()
          let id = $(this).data('id');
          $.ajax({
              url: `/menu/cart`,
              method: 'DELETE',
              data: {"cart_id": id},
              success: (res) => {
                Swal.fire({
                  text: res.message,
                  icon: 'success',
                  confirmButtonText: 'Containue'
                })
                cart()

                if($('#order_items').length){
                  $.ajax({
                    url: "/checkout-get",
                    method: 'GET',
                    data: {},
                    success: (res) => {
                      $('#order_items').html(res)
                    }
                  })
                }

              }
          })
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

        @if (session('update')) 
            Toast.fire({
              icon: 'success',
              title: "{{ session('update') }}"
            })
        @endif



        // Send Firebase Notification

        var firebaseConfig = {
            apiKey: "AIzaSyCzAPl3yxJkIwLh6zByZDh--TaaKQOm9ew", 
            authDomain: "laravelfcm-b29ba.firebaseapp.com",
            databaseURL: "https://XXXX.firebaseio.com",
            projectId: "laravelfcm-b29ba",
            storageBucket: "laravelfcm-b29ba.appspot.com",
            messagingSenderId: "4333973945",
            appId: "1:4333973945:web:775e456ac4358cb8554668",                                                                                                      
            measurementId: "G-44YTE2STYX"
        };
        
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });


    })
</script>


</body>

</html>