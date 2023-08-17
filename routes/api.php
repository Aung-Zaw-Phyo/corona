<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::post('book-table', [BookingController::class, 'bookTable']);

Route::get('discount-product', [ProductController::class, 'discountMenu']);
Route::get('product', [ProductController::class, 'menu']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('profile/update', [AuthController::class, 'updateProfile']);

    Route::post('add-to-cart', [ProductController::class, 'addToCart']);
    Route::get('get-cart-data', [ProductController::class, 'getData']);

    Route::post('create-payment-intent', [ProductController::class, 'createPaymentIntent']);

    Route::get('order', [ProductController::class, 'order']);
});
