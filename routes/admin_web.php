<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\PaymentController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\DiscountController;
use App\Http\Controllers\backend\AdminUserController;
use App\Http\Controllers\backend\BookingController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\OrderController;

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



Route::middleware('auth:admin_user')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'home'])->name('home');

    Route::resource('admin-user', AdminUserController::class);
    Route::get('admin-user/data-table/ssd', [AdminUserController::class, 'ssd']);

    Route::resource('customer', CustomerController::class);
    Route::get('customer/data-table/ssd', [CustomerController::class, 'ssd']);

    Route::resource('category', CategoryController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('category/data-table/ssd', [CategoryController::class, 'ssd']);

    Route::resource('discount', DiscountController::class);
    Route::get('discount/data-table/ssd', [DiscountController::class, 'ssd']);

    Route::resource('product', ProductController::class);
    Route::get('product/data-table/ssd', [ProductController::class, 'ssd']);

    Route::resource('payment', PaymentController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('payment/data-table/ssd', [PaymentController::class, 'ssd']);

    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::post('order/complete/{id}', [OrderController::class, 'orderComplete'])->name('order.complete');

    Route::get('booking', [BookingController::class, 'index'])->name('booking.index');
});