<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
| Đây là nơi bạn có thể đăng ký các route API cho ứng dụng của mình.
| Tất cả các route này sẽ được nạp bởi RouteServiceProvider và được gán
| cho nhóm middleware "api".
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Payment Routes
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);  // Danh sách thanh toán
    Route::post('/create', [PaymentController::class, 'store']);  // Tạo mới thanh toán
    Route::get('/{id}', [PaymentController::class, 'show']);  // Thông tin thanh toán theo ID
    Route::put('/{id}', [PaymentController::class, 'update']);  // Cập nhật thanh toán
    Route::delete('/{id}', [PaymentController::class, 'destroy']);  // Xóa thanh toán
    
    // Phương thức thanh toán online
    Route::post('/momo', [PaymentController::class, 'online_checkout']);  // Thanh toán qua MoMo
    Route::post('/vnpay', [PaymentController::class, 'online_checkout']);  // Thanh toán qua VNPay
});

// Route cho thanh toán thành công
Route::get('/thank-you', [PaymentController::class, 'thankYou']);  // Không còn dùng view mà là trả về thông báo JSON
