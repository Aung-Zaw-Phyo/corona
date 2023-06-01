

@foreach ($carts as $cart)
<div class="card border-0 mb-2">
  <div class="card-body p-2 px-3 d-flex align-items-center">
    <div class="img_container mr-3">
      <img src="{{ $cart->product->image_path() }}" alt="">
    </div>
    <div>
      <p class="mb-0">{{ $cart->product->name }}</p>
      <p class="mb-1"> {{ $cart->product->price }} <small>MMK</small></p>
      <button class="remove_cart" data-id="{{ $cart->id }}"><i class="fa-solid fa-circle-minus"></i> Remove</button>
    </div> 
  </div>
</div>
@endforeach
