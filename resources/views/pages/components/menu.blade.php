

    @foreach ($products as $product)
      <div class="col-sm-6 col-lg-4 all {{ $product->category ? $product->category->name : '' }}">
          <div class="box">
            <div>
              <div class="img-box">
                <img src="{{ $product->image_path() }}" alt="">
              </div>
              <div class="detail-box">
                <h5>
                  {{ $product->name }}
                </h5>
                <p>
                    {{ Str::limit($product->description, 60) }}
                </p>
                <div class="options">
                  <h6>
                    {{ $product->price }} <small>MMK</small>
                  </h6>
                  @php
                      $product['discount'] = 0;
                  @endphp
                  <a href="#" class="add_to_cart" data-product="{{ base64_encode(json_encode($product, JSON_HEX_APOS)) }}">
                    <i class="fa-solid fa-cart-shopping text-light"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
      </div>
    @endforeach
