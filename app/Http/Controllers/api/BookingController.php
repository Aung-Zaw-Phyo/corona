<?php

namespace App\Http\Controllers\api;

use App\Models\BookTable;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    use HttpResponses;
    public function bookTable (Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'nullable|email',
                'phone' => 'required|min:9|max:14',
                'person' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

            if($validator->fails()) {
                return $this->error($validator->errors()->first(), null, 422);
            }

            $booking = new BookTable();
            $booking->name = $request->name;
            $booking->email = $request->email;
            $booking->phone = $request->phone;
            $booking->person = $request->person;
            $booking->date = $request->date;
            $booking->time = $request->time;
            $booking->save();

            return $this->success('Successfully booked a table.', ['booking' => $booking], 201);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), null, 500);
        }
    }
}
