@extends('layouts.app')

@section('extra_css')
    <style>
        table td {
            vertical-align: middle !important;
            text-align: center !important;
        }

        button:focus,
        input:focus{
            outline: none;
            box-shadow: none;
        }
        a,
        a:hover{
            text-decoration: none;
        }

        /*--------------------------*/
        .qty-container{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qty-container .input-qty{
            text-align: center;
            height: 42px;
            width: 42px;
            border: 1px solid #d4d4d4;
            max-width: 80px;
        }
        .qty-container .qty-btn-minus,
        .qty-container .qty-btn-plus{
            border: 1px solid #d4d4d4;
            padding: 10px 13px;
            font-size: 10px;
            height: 42px;
            width: 42px;
            transition: 0.3s;
        }
        .qty-container .qty-btn-plus{
            margin-left: -1px;
        }
        .qty-container .qty-btn-minus{
            margin-right: -1px;
        }


        /*---------------------------*/
        .btn-cornered,
        .input-cornered{
            border-radius: 4px;
        }
        .btn-rounded{
            border-radius: 50%;
        }
        .input-rounded{
            border-radius: 50px;
        }

        textarea {
            height: 80px !important;
        }

    </style>
@endsection

@section('content')

    <div class="hero_area">
        <div class="bg-box">
        <img src="{{ asset('frontend/assets/images/hero-bg.jpg') }}" alt="">
        </div>
        @include('layouts.header_navbar')
    </div>

    <section class="layout_padding order_section">
        <div class="container">
            <div class="alert alert-warning alert-dismissible fade show warning-alert text-center d-none" role="alert">
                <span class="warning-message"></span>
                {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead>
                        <th class="text-center">Image</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Per Discount (%)</th>
                        <th class="text-center">Sub Total</th>
                        <th class="text-center">Quantity</th>
                    </thead>
                    <tbody id="order_items">
                        @foreach ($order_items as $item)
                        <tr id="{{$item->id}}_item_row">
                            <td class="text-center"><img class="p-1" width="80px" src="{{ $item->product->image_path() }}" alt=""></td>
                            <td class="text-center">{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->product->price }} <small>(MMK)</small></td>
                            <td class="text-center">
                                @if ($item->discount_percent)
                                <span class="badge badge-dark">{{ $item->discount_percent }} %</span>
                                @else
                                -
                                @endif
                            </td>
                            <td class="text-center"><span id="{{$item->id}}_item_price" class="sub_total" value="{{ $item->total_price }}">{{ $item->total_price }}</span> <small>(MMK)</small></td>
                            <td class="text-center">
                                <div class="qty-container">
                                    <button class="qty-btn-minus btn-light" data-id="{{ $item->id }}" type="button"><i class="fa fa-minus"></i></button>
                                    <input type="text" name="qty" value="{{ $item->quantity }}" class="input-qty" readonly/>
                                    <button class="qty-btn-plus btn-light" data-id="{{ $item->id }}" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        <tr style="background-color: #eeeeee34">
                            <th class="text-center"  colspan="4">Total Price</th>
                            <th class="" colspan="2"><div id="total_price"></div></th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form_container">
                <div class="alert-message">
                    @if ($errors->first())
                        <div class="alert alert-warning">{{ $errors->first() }}</div>
                    @endif
                </div>
                <form action="{{ route('pages.checkout.checkout') }}" method="POST" id="checkout-form">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}" />
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" value='{{ old('phone') }}'/>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="address" id="" cols="30" rows="10" placeholder="Enter address">{{ old('address') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="message" id="" cols="30" rows="10" placeholder="Enter message">{{ old('message') }}</textarea>
                    </div>
                    <div class="btn_box d-flex justify-content-end">
                        <button type="submit">
                            CHECKOUT
                        </button>
                    </div>
                </form>
            </div>
        </div>
      </section>

    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">

        <div class="row">
            <div class="col-md-6 ">
            <div class="img-box">
                <img src="{{ asset('frontend/assets/images/about-img.png') }}" alt="">
            </div>
            </div>
            <div class="col-md-6">
            <div class="detail-box">
                <div class="heading_container">
                <h2>
                    We Are Feane
                </h2>
                </div>
                <p>
                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
                in some form, by injected humour, or randomised words which don't look even slightly believable. If you
                are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
                the middle of text. All
                </p>
                <a href="">
                Read More
                </a>
            </div>
            </div>
        </div>
        </div>
    </section>

  <!-- end about section -->

@endsection

@section('script')
{!! JsValidator::formRequest('App\Http\Requests\StoreCheckout', '#checkout-form') !!}
<script>
    $(document).ready(function () {
        const getTotalPrice = () => {
            document.getElementById('total_price').innerHTML = ''
            const priceTags = document.getElementsByClassName('sub_total')
            let total_price = 0
            for (let i = 0; i < priceTags.length; i++) {
                total_price += Number($(priceTags[i]).attr('value'));
            }
            document.getElementById('total_price').innerHTML = `${total_price} <small>MMK</small>`
        }
        getTotalPrice()

        const cart = function () {
            $.ajax({
                url: `/menu-cart`,
                method: 'GET',
                success: (res) => {
                $('.cart_layout #carts').html(res)
                }
            })
        }

        var buttonPlus  = $(".qty-btn-plus");
        var buttonMinus = $(".qty-btn-minus");

        var incrementPlus = buttonPlus.click(function() {
            $(this).prop('disabled', true);
            var $n = $(this).parent(".qty-container").find(".input-qty");
            $n.val(Number($n.val())+1 );
            let order_item_id = $(this).data('id')
            let quantity = $n.val()
            $.ajax({
                url: '/checkout/menu/control-quantity',
                method: 'GET',
                data: {"order_item_id": order_item_id, "quantity": quantity, "status": 'increase'},
                success: (res) => {
                    console.log('### ', res.message)
                    if(res.status == 200) {
                        $n.val(res.data.quantity)
                        $(`#${res.data.id}_item_price`).html(res.data.total_price)
                        $(`#${res.data.id}_item_price`).attr('value', res.data.total_price)
                    }

                    if(res.status == 404) {
                        $n.val(res.data.quantity)
                        $(`#${res.data.id}_item_price`).html(res.data.total_price)
                        $(`#${res.data.id}_item_price`).attr('value', res.data.total_price)

                        $('.warning-message').html(res.message)
                        let re = $('.warning-alert').removeClass('d-none')
                    }

                    $(this).prop('disabled', false);
                    getTotalPrice()
                }
            })
        });

        var incrementMinus = buttonMinus.click(function() {
            $(this).prop('disabled', true);
            var $n = $(this).parent(".qty-container").find(".input-qty");
            $n.val(Number($n.val())-1 );
            let order_item_id = $(this).data('id')
            let quantity = $n.val()

            $.ajax({
                url: '/checkout/menu/control-quantity',
                method: 'GET',
                data: {"order_item_id": order_item_id, "quantity": quantity, "status": "decrease"},
                success: (res) => {
                    if(res.status == 200) {
                        $n.val(res.data.quantity)
                        $(`#${res.data.id}_item_price`).html(res.data.total_price)
                        $(`#${res.data.id}_item_price`).attr('value', res.data.total_price)
                    }else if(res.status == 201){
                        $(`#${res.data.id}_item_row`).hide('slow')
                    }else {
                        console.log(res.message)
                    }
                    $(this).prop('disabled', false);
                    getTotalPrice()
                    if(quantity == 0) {
                        cart()
                    }
                }
            })
        });

    })      
</script> 
@endsection