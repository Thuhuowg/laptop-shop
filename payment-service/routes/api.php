<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::post('/payments', [PaymentController::class, 'store']); // Lưu thanh toán mới
Route::post('/payments/checkout', [PaymentController::class, 'online_checkout']); // Xử lý thanh toán online
Route::post('/payment', [TestController::class, 'payment']);
Route::get('/return', [TestController::class, 'return']);