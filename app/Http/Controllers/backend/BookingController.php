<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookTable;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index (Request $request) {
        $bookings = BookTable::orderBy('created_at', 'DESC');
        $search = $request->search;
        if($search) {
            $search = '%' . $search . '%';
            $bookings = $bookings->where('name', 'LIKE', $search)->orWhere('phone', 'LIKE', $search)->orWhere('email', 'LIKE', $search);
        }
        $bookings = $bookings->paginate(9);
        return view('backend.booking.index', compact('bookings'));
    }
}
