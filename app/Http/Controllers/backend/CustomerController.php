<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index () {
        return view('backend.customer.index');
    }

    public function show () {
        return view('backend.customer.show');
    }

    public function edit () {
        return view('backend.customer.edit');
    }
}
