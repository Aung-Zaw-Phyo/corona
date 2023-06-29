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
    <th class="" colspan="2"><div id="total_price">{{ $totalPrice }} <small>MMK</small></div></th>
</tr>