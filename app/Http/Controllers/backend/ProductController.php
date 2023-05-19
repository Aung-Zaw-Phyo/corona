<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index () {
        return view('backend.product.index');
    }

    public function show () {
        return view('backend.product.show');
    }

    public function edit () {
        return view('backend.product.edit');
    }
}
