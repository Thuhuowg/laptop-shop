<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/cart', [CartController::class, 'index']); // Lấy danh sách giỏ hàng
Route::post('/cart', [CartController::class, 'store']); // Thêm sản phẩm vào giỏ hàng
Route::put('/cart/{id}', [CartController::class, 'update']); // Cập nhật số lượng sản phẩm
Route::delete('/cart/{id}', [CartController::class, 'destroy']); // Xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart', [CartController::class, 'clear']); // Xóa toàn bộ giỏ hàng