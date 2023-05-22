<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\AdminUserController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ProductController;

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

    Route::resource('product', ProductController::class);

});