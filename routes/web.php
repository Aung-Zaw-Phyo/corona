<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\PagesController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\frontend\BookingController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\ProfileController;
use App\Http\Controllers\frontend\CheckoutController;

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

// Route::get('/cc', function () {
//     Artisan::call('cache:clear');
//     echo '<script>alert("cache clear Success")</script>';
// });
// Route::get('/ccc', function () {
//     Artisan::call('config:cache');
//     echo '<script>alert("config cache Success")</script>';
// });
// Route::get('/vc', function () {
//     Artisan::call('view:clear');
//     echo '<script>alert("view clear Success")</script>';
// });
// Route::get('/cr', function () {
//     Artisan::call('route:cache');
//     echo '<script>alert("route clear Success")</script>';
// });
// Route::get('/coc', function () {
//     Artisan::call('config:clear');
//     echo '<script>alert("config clear Success")</script>';
// });


Auth::routes();

Route::post('/webhook', [CheckoutController::class, 'webhook'])->name('webhook');
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::post('/create-otp', [RegisterController::class, 'createOTP']);

Route::name('pages.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::get('/menu', [ProductController::class, 'menu'])->name('menu');
    Route::get('/menu-get', [ProductController::class, 'menuGet']);
    Route::post('/menu/cart', [ProductController::class, 'createCart']);
    Route::delete('/menu/cart', [ProductController::class, 'removeCart']);
    Route::get('/menu-cart',[ProductController::class, 'menuCart']);

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
    Route::get('/checkout-get', [CheckoutController::class, 'checkoutGet'])->name('checkout.get')->middleware('auth');
    Route::get('/checkout/menu/control-quantity', [CheckoutController::class, 'controlQuantity']);
    Route::post('/checkout/checkout', [CheckoutController::class, 'checkout'])->name('checkout.checkout')->middleware('auth');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    Route::get('/about', [PagesController::class, 'about'])->name('about');
    Route::get('/booking', [PagesController::class, 'booking'])->name('booking');
    Route::post('booking', [BookingController::class, 'booking']);

    Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
    Route::post('/profile/update/{id}', [ProfileController::class, 'updateInfo'])->name('updateProfileInfo')->middleware('auth');

    Route::get('order', [ProductController::class, 'order'])->middleware('auth');
});