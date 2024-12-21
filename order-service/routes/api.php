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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('orders')->group(function () {
    // Xem danh sách đơn hàng
    Route::get('/', [OrderController::class, 'index']);

    // Xem chi tiết đơn hàng
    Route::get('/{orderId}', [OrderController::class, 'show']);

    // Tạo đơn hàng mới
    Route::post('/create', [OrderController::class, 'store']);

    // Xoá đơn hàng
    Route::delete('/{orderId}', [OrderController::class, 'destroy']);
});
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'user']);
Route::post('register', [AuthController::class, 'register']);

