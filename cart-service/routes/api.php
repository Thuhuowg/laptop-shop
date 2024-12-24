<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

// Lấy danh sách giỏ hàng - cần xác thực người dùng
Route::middleware('auth:api')->get('/cart', [CartController::class, 'getCart']);

// Thêm sản phẩm vào giỏ hàng
Route::post('/cart', [CartController::class, 'store']);

// Cập nhật số lượng sản phẩm
Route::put('/cart/{id}', [CartController::class, 'update']);

// Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/{id}', [CartController::class, 'destroy']);

// Xóa toàn bộ giỏ hàng
Route::delete('/cart/clear', [CartController::class, 'clear']);
