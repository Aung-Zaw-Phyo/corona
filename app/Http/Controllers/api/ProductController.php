<?php

namespace App\Http\Controllers\api;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\OrderItem;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\OrderItemResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use HttpResponses;

    public function menu(Request $request)
    {
        $categories = Category::all();
        $products = Product::with('category')->where('status', true)->where('quantity', '>', 0)->orderBy('created_at', 'DESC');
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        if ($request->search) {
            $products = $products->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $products = $products->paginate(8);
        $data = ProductResource::collection($products)->additional(['categories' => $categories, 'status' => true, 'message' => 'Fetched products successfully.']);
        return $data;
    }

    public function discountMenu()
    {
        $discounts = Discount::where('status', true)->get();
        $discounts = DiscountResource::collection($discounts)->additional(['status' => true, 'message' => 'Fetched discount products successfully.']);
        return $discounts;
    }

    public function getUpdatedOrderItems()
    {
        $updatedItems = OrderItem::where('user_id', auth()->user()->id)->where('status', 'pending')->get();
        return OrderItemResource::collection($updatedItems);
    }

    public function addToCart(Request $request)
    {
        // check three action and occur one action
        try {
            $items = $request->items;
            $authUserId = auth()->user()->id;
            $idsOfItems = array_map(function ($item) {
                return $item['id'];
            }, $items);

            // add or remove quantity and add new item
            foreach ($items as $item) {
                $existingItem = OrderItem::where('user_id', $authUserId)->where('status', 'pending')->where('product_id', $item['id'])->first();
                if ($existingItem) {
                    if ($item['quantity'] != $existingItem->quantity) {
                        $isAdd = $item['quantity'] > $existingItem->quantity;
                        $product = Product::find($existingItem->product_id);
                        if ($isAdd && $product->quantity == 0) {
                            $updatedItems = $this->getUpdatedOrderItems();
                            return $this->error('Item is not enough.', ['items' => $updatedItems], 422);
                        }
                        $product->quantity = $isAdd ? $product->quantity - 1 : $product->quantity + 1;
                        $product->update();

                        if (!$isAdd && $item['quantity'] == 0) {
                            $existingItem->delete();
                        } else {
                            $existingItem->quantity = $item['quantity'];
                            $existingItem->total_price = $item['amount'];
                            $existingItem->discount_percent = $item['discount'];
                            $existingItem->update();
                        }


                        $updatedItems = $this->getUpdatedOrderItems();
                        return $this->success($isAdd ? "Item is added to cart successfully." : 'Item is removed from cart successfully.', ['items' => $updatedItems], 200);
                    }
                } else {
                    $product = Product::find($item['id']);
                    if ($product->quantity == 0) {
                        $updatedItems = $this->getUpdatedOrderItems();
                        return $this->error('Item is not enough.', ['items' => $updatedItems], 422);
                    }
                    $product->quantity = $product->quantity - 1;
                    $product->update();

                    $newItem = new OrderItem();
                    $newItem->user_id = $authUserId;
                    $newItem->product_id = $item['id'];
                    $newItem->quantity = $item['quantity'];
                    $newItem->total_price = $item['amount'];
                    $newItem->discount_percent = $item['discount'];
                    $newItem->save();

                    $updatedItems = $this->getUpdatedOrderItems();
                    return $this->success($item['name'] . ' is added to cart successfully.', ['items' => $updatedItems], 200);
                }
            }

            // remove item
            $existingItems = OrderItem::where('user_id', $authUserId)->where('status', 'pending')->get();
            foreach ($existingItems as $existingItem) {
                $isExist = Arr::exists($idsOfItems, $existingItem->product_id);

                if (!$isExist) {
                    $removeItem = OrderItem::where('user_id', $authUserId)
                        ->where('status', 'pending')
                        ->where('product_id', $existingItem->product_id)
                        ->where('order_id', $existingItem->order_id)
                        ->first();
                    $removeItem->delete();

                    $product = Product::find($existingItem->product_id);
                    $product->quantity = $product->quantity + 1;
                    $product->update();

                    $updatedItems = $this->getUpdatedOrderItems();
                    return $this->success('Item is removed from cart successfully.', ['items' => $updatedItems], 200);
                }
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }

    public function getData()
    {
        try {
            $order_items = OrderItem::with('product', 'user')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();
            $order_items = OrderItemResource::collection($order_items);
            return $this->success('Fetched cart data successfully.', ['items' => $order_items], 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }



    public function createPaymentIntent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'paymentMethodId' => 'required',
                'name' => 'required',
                'phone' => 'required|min:11|max:14',
                'address' => 'required',
                'message' => 'nullable',
            ], [
                'paymentMethodId.required' => 'Something wrong, please check your internet connection.'
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), null, 422);
            }

            // Initialize Stripe with your secret key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Retrieve paymentMethodId from the request
            $paymentMethodId = $request->input('paymentMethodId');

            // Create a PaymentIntent to confirm the payment
            $paymentIntent = \Stripe\PaymentIntent::create([
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'amount' => 1000, // Amount in cents
                'currency' => 'usd',
            ]);

            $order_items = OrderItem::with('product', 'user')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();

            if (count($order_items) === 0) {
                return $this->error('Please add menu to cart before checkout', null, 422);
            }

            $order_no = UUIDGenerate::order_number();
            $order = new Order();
            $order->order_no = $order_no;
            $order->user_id = auth()->user()->id;
            $order->session_id = $paymentMethodId;
            $order->status = 'paid';
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->message = $request->message;
            $order->save();

            foreach ($order_items as $item) {
                $item->order_id = $order->id;
                $item->status = 'completed';
                $item->save();
            }

            $order_items = OrderItem::with('product', 'user')->where('user_id', auth()->user()->id)->where('status', 'pending')->get();
            $order_items = OrderItemResource::collection($order_items);

            // Handle success or failure response here and return appropriate JSON response
            return $this->success('Payment charged successfully', ['items' => $order_items], 200);
        } catch (\Exception $e) {
            // Handle error and return appropriate JSON response
            return $this->error($e->getMessage(), null, 500);
        }
    }


    public function order()
    {
        try {
            $orders = Order::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC');
            $orders = $orders->paginate(6);
            $data = OrderResource::collection($orders)->additional(['orders' => $orders, 'status' => true, 'message' => 'Fetched orders successfully.']);
            return $data;
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }
}
