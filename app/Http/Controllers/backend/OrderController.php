<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index (Request $request) {
        $orders = Order::orderBy('created_at', 'DESC');
        $search = $request->search;
        if($search) {
            $search = '%' . $search . '%';
            $orders = $orders->where('order_no', 'LIKE', $search)->orWhere('phone', 'LIKE', $search)->orWhere('name', 'LIKE', $search);
        }
        $orders = $orders->paginate(9);
        return view('backend.order.index', compact('orders'));
    }

    public function orderComplete (Request $request, $id) {
        $order = Order::find($id);
        if(!$order) {
            return redirect()->back()->with('fail', 'Order not found!');
        }

        $order->status = 'completed';
        $order->update();
        return redirect()->back()->with('create', 'Complete order - ' . $order->order_no);
    }
}
