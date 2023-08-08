<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\FirebaseNoti;
use App\Models\User;
use App\Models\Order;
use Stripe\StripeClient;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckout;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function index () {
        $order_items = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();
        return view('pages.checkout', compact('order_items'));
    }

    public function checkoutGet () {
        $order_items = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();
        $totalPrice = 0;
        foreach($order_items as $item) {
            $totalPrice += $item->total_price;
        }
        return view('pages.components.order_items', compact('order_items', 'totalPrice'))->render();
    }

    public function controlQuantity (Request $request) {
        $order_item = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', true)->where('id', $request->order_item_id)->firstOrFail();
        
        // If customer increase count, decrease product's count. | If customer decrease count, increase product's count.
        $product = $order_item->product;
        if($request->status == 'increase') {
            if($product->quantity == 0 ){
                return [
                    'status' => 404,
                    'message' => $order_item->product->name . " is not enough.",
                    'data' => $order_item
                ];
            }
            $decreaseQty = $request->quantity - $order_item->quantity;
            $product->quantity = $product->quantity - $decreaseQty;
            $product->update();
        }else if ($request->status == 'decrease'){
            $increaseQty = $order_item->quantity - $request->quantity;
            $product->quantity = $product->quantity + $increaseQty;
            $product->update();
        }

        if($product->quantity == 0) {
            $product->status = false;
            $product->update();
        }


        if($request->quantity == 0) {
            $order_item->delete();
            return [
                'status' => 201,
                'message' => $order_item->product->name . " is deleted.",
                'data' => $order_item
            ];
        }else {
            $order_item->quantity = $request->quantity; 
            $total_price = (((100 - $order_item->discount_percent) / 100) * $order_item->product->price) * $request->quantity;
            $order_item->total_price = number_format($total_price, 2, '.', '');
            $order_item->update();
            return [
                'status' => 200,
                'message' => $request->status == 'increase' ? $order_item->product->name . " is increased." : $order_item->product->name . " is decreased.",
                'data' => $order_item
            ];

        }        
    }

    public function checkout (StoreCheckout $request) {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $order_items = OrderItem::with('product')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();
        // return $order_items;
        $line_items = [];
        $total_price = 0 ;
        foreach($order_items as $item) {
            $line_items[] = [
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                    'name' => $item->product->name,
                    'images' =>  [$item->product->image_path()]
                  ],
                  'unit_amount' => $item->total_price * 100,
                ],
                'quantity' => 1,
            ];
            $total_price += $item->total_price;
        }

        $customer = $stripe->customers->create(); // Create a new customer
        $session = $stripe->checkout->sessions->create([
            'customer' => $customer->id, // Attach the customer to the session
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('pages.checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('pages.checkout.cancel', [], true),
        ]);

        $order_no = UUIDGenerate::order_number();
        $order = new Order();
        $order->order_no = $order_no;
        $order->user_id = auth()->user()->id;
        $order->session_id = $session->id;
        $order->status = 'unpaid';
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->message = $request->message;
        $order->save();

        foreach($order_items as $item) {
            $item->order_id = $order->id;
            $item->save();
        }

        return redirect($session->url);
    }

    public function success (Request $request) {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');
        try {
            $session = $stripe->checkout->sessions->retrieve($session_id);
            if(!$session) {
                throw new NotFoundHttpException();
            }
            $customer = $stripe->customers->retrieve($session->customer);
            // $customer = $session->customer_details;

            $order = Order::where('session_id', $session_id)->first();
            if(!$order) {
                throw new NotFoundHttpException();
            }

            if($order->status === 'unpaid'){
                $order->status = 'paid';
                $order->update();
                $order_items = $order->order_items;
                foreach($order_items as $item) {
                    $item->status = 'completed';
                    $item->save();
                }
            }

            return view('pages.success', compact('customer'));
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

    public function cancel () {
        return redirect()->route('pages.checkout.index');
    }

    // stripe listen --forward-to localhost:8000/webhook
    // stripe trigger payment_intent.succeeded
    public function webhook()
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $order = Order::with('user')->where('session_id', $session->id)->first();
                if($order->status === 'unpaid'){
                    $order->status = 'paid';
                    $order->update();
                    $order_items = $order->order_items;
                    foreach($order_items as $item) {
                        $item->status = 'completed';
                        $item->save();
                    }
                }
                $token = $order->user->device_token;
                FirebaseNoti::sendNotification($token, 'CORONA', 'Payment Success');
        
            // ... handle other event types

            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }

    
}
