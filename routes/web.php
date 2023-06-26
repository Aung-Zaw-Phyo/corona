<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\PagesController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::name('pages.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::get('/menu', [ProductController::class, 'menu'])->name('menu');
    Route::get('/menu-get', [ProductController::class, 'menuGet']);
    Route::post('/menu/cart', [ProductController::class, 'createCart']);
    Route::delete('/menu/cart', [ProductController::class, 'removeCart']);
    Route::get('/menu-cart',[ProductController::class, 'menuCart']);

    Route::get('/order', [OrderController::class, 'index'])->middleware('auth');
    Route::get('/order/menu/control-quantity', [OrderController::class, 'controlQuantity']);

    Route::get('/about', [PagesController::class, 'about'])->name('about');
    Route::get('/booking', [PagesController::class, 'booking'])->name('booking');

    Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
    Route::post('/profile/update/{id}', [ProfileController::class, 'updateInfo'])->name('updateProfileInfo')->middleware('auth');
});