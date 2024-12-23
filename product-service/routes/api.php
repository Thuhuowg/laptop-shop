<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DisCountController;
use App\Http\Controllers\ProductController;
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
//Category
Route::get('all-category-product', [CategoryController::class, 'all_category_product'])->name('all-category');
Route::get('edit-category-product/{category_product_id}', [CategoryController::class, 'edit_category_product']);
Route::get('unactive-category-product/{category_product_id}', [CategoryController::class, 'unactive_category_product']);
Route::get('active-category-product/{category_product_id}', [CategoryController::class, 'active_category_product']);
Route::post('save-category', [CategoryController::class, 'save_category_product'])->name('api.save-category');
Route::put('update-category/{category_product_id}', [CategoryController::class, 'update_category_product']);
Route::delete('delete-category-product/{category_product_id}', [CategoryController::class, 'delete_category_product']);

//Product
Route::get('add-product',[ProductController::class,'add_product']);
Route::get('edit-product/{product_id}',[ProductController::class,'edit_product']);
Route::get('delete-product/{product_id}',[ProductController::class,'delete_product']);
Route::get('all-product',[ProductController::class,'all_product'])->name('all-product');
Route::get('unactive-product/{product_id}',[ProductController::class,'unactive_product']);
Route::get('active-product/{product_id}',[ProductController::class,'active_product']);
Route::post('save-product',[ProductController::class,'save_product']);
Route::put('update-product/{product_id}',[ProductController::class,'update_product']);

//Discount
Route::get('all-discount',[DisCountController::class,'all_discount'])->name('all-discount');
Route::get('edit-discount/{discount_id}', [DisCountController::class, 'edit_discount']);
Route::post('save-discount', [DisCountController::class, 'save_discount']);
Route::put('update-discount/{discount_id}', [DisCountController::class, 'update_discount']);
Route::delete('delete-discount/{discount_id}', [DisCountController::class, 'delete_discount'])->name('api.delete-discount');

