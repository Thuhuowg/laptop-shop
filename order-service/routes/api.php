<?php

use Illuminate\Http\Request;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/orders', [OrderController::class, 'index']);                    // Lấy tất cả đơn hàng
Route::get('/orders/user/{userId}', [OrderController::class, 'getOrdersByUserId']); // Lấy đơn hàng theo user_id
Route::get('/orders/{id}', [OrderController::class, 'getOrderById']); // Lấy đơn hàng theo ID
Route::post('/orders', [OrderController::class, 'store']);                    // Tạo đơn hàng mới
Route::put('/orders/{id}', [OrderController::class, 'update']);               // Cập nhật đơn hàng
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);         

