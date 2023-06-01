<?php

namespace App\Http\Controllers\frontend;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index () {
        $order_items = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', true)->get();
        return view('pages.order', compact('order_items'));
    }

    public function controlQuantity (Request $request) {
        $order_item = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', true)->where('id', $request->order_item_id)->firstOrFail();

        if($request->quantity == 0) {
            $order_item->delete();
            return [
                'status' => 201,
                'message' => $order_item->product->name . " is deleted.",
                'data' => $order_item
            ];
        }else {
            $order_item->quantity = $request->quantity;
            $order_item->total_price = $order_item->product->price * $request->quantity;
            $order_item->update();
            return [
                'status' => 200,
                'message' => $request->status == 'increase' ? $order_item->product->name . " is increased." : $order_item->product->name . " is decreased.",
                'data' => $order_item
            ];

        }        
    }
}
