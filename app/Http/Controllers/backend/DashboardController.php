<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookTable;
use App\Models\Order;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home () {
        $today = Carbon::today()->toDate()->format('Y-m-d');
        $booking_lists = BookTable::where('date', $today)->orderBy('time', 'ASC')->get();
        $orders = Order::whereDate('created_at', $today)->get();
        return view('backend.home', compact('booking_lists', 'orders'));
    }
}
