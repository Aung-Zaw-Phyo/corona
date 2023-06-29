<?php

namespace App\Helpers;

use App\Models\Order;

class UUIDGenerate {
    public static function order_number () {
        $number = mt_rand(1000000000000000, 9999999999999999);
        if(Order::where('order_no', $number)->exists()){
            self::account_number();
        }
        return $number;
    }
}