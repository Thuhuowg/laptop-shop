<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::prefix('v1')->group(function () {
    // Routes cho Discount
    Route::get('discounts', [DiscountController::class, 'index']);
    Route::get('discounts/{id}', [DiscountController::class, 'show']);
    Route::post('discounts', [DiscountController::class, 'store']);
    Route::put('discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('discounts/{id}', [DiscountController::class, 'destroy']);

    // Routes cho Category
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    
    // Routes cho Product
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('productsdetail/{id}', [ProductController::class, 'showdetail']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});

Route::get('/products/filter', [ProductController::class, 'filterProducts']);          

