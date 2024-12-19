<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

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

// Payment Routes
// Payment Routes
Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('payments.index'); // List all payments
    Route::get('/create', [PaymentController::class, 'create'])->name('payments.create'); // Show form to create a new payment
    Route::post('/', [PaymentController::class, 'store'])->name('payments.store'); // Store a new payment in the database
    Route::get('/{id}', [PaymentController::class, 'show'])->name('payments.show'); // Show payment details
    
    // Cập nhật thanh toán
    Route::put('/{id}', [PaymentController::class, 'update'])->name('payments.update'); // Update payment

    // Xóa thanh toán
    Route::delete('/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy'); // Delete payment
    
    // Online Payment Methods
    Route::post('/momo', [PaymentController::class, 'online_checkout'])->name('payments.momo');
    Route::post('/vnpay', [PaymentController::class, 'online_checkout'])->name('payments.vnpay');
});


// Thank You Route
Route::get('/thank-you', [PaymentController::class, 'thankYou'])->name('thank-you');
