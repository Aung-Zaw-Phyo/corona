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

    </style>
@endsection

@section('content')

    <div class="hero_area">
        <div class="bg-box">
        <img src="{{ asset('frontend/assets/images/hero-bg.jpg') }}" alt="">
        </div>
        @include('layouts.header_navbar')
    </div>

    <section class="layout_padding">
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th class="text-center">Image</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Sub Total</th>
                        <th class="text-center">Quantity</th>
                    </thead>
                    <tbody>
                        @foreach ($order_items as $item)
                        <tr id="{{$item->id}}_item_row">
                            <td class="text-center"><img class="p-1" width="80px" src="{{ $item->product->image_path() }}" alt=""></td>
                            <td class="text-center">{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->product->price }} <small>(MMK)</small></td>
                            <td class="text-center"><span id="{{$item->id}}_item_price">{{ $item->product->price * $item->quantity }}</span> <small>(MMK)</small></td>
                            <td class="text-center">
                                <div class="qty-container">
                                    <button class="qty-btn-minus btn-light" data-id="{{ $item->id }}" type="button"><i class="fa fa-minus"></i></button>
                                    <input type="text" name="qty" value="{{ $item->quantity }}" class="input-qty" readonly/>
                                    <button class="qty-btn-plus btn-light" data-id="{{ $item->id }}" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
<script>
    $(document).ready(function () {
        var buttonPlus  = $(".qty-btn-plus");
        var buttonMinus = $(".qty-btn-minus");

        var incrementPlus = buttonPlus.click(function() {
            $(this).prop('disabled', true);
            var $n = $(this).parent(".qty-container").find(".input-qty");
            $n.val(Number($n.val())+1 );
            let order_item_id = $(this).data('id')
            let quantity = $n.val()
            $.ajax({
                url: '/order/menu/control-quantity',
                method: 'GET',
                data: {"order_item_id": order_item_id, "quantity": quantity, "status": 'increase'},
                success: (res) => {
                    console.log(res.message)
                    if(res.status == 200) {
                        $n.val(res.data.quantity)
                        $(`#${res.data.id}_item_price`).html(res.data.total_price)
                    }
                    $(this).prop('disabled', false);
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
                url: '/order/menu/control-quantity',
                method: 'GET',
                data: {"order_item_id": order_item_id, "quantity": quantity, "status": "decrease"},
                success: (res) => {
                    console.log(res.message)
                    if(res.status == 200) {
                        $n.val(res.data.quantity)
                        $(`#${res.data.id}_item_price`).html(res.data.total_price)
                    }else if(res.status == 201){
                        $(`#${res.data.id}_item_row`).hide()
                    }
                    $(this).prop('disabled', false);
                }
            })
        });

    })      
</script> 
@endsection