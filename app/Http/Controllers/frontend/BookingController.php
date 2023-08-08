<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBooking;
use App\Models\BookTable;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function booking (StoreBooking $request) {
        $booking = new BookTable();
        $booking->name = $request->name;
        $booking->email = $request->name;
        $booking->phone = $request->phone;
        $booking->person = $request->person;
        $booking->date = $request->date;
        $booking->time = $request->time;
        $booking->save();

        return redirect()->back()->with('success', 'Booked a table successfully!');
    }
}
