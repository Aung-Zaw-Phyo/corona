<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home () {
        return view('pages.home');
    }

    public function menu () {
        return view('pages.menu');
    }

    public function about () {
        return view('pages.about');
    }

    public function booking () {
        return view('pages.booking');
    }
}
