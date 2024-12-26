<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/users', function () {
    return view('users');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::get('/home', function () {
    return view('home');
});
Route::get('/cart', function () {
    return view('cart');
});
Route::get('/checkout', function () {
    return view('checkout');
});
Route::get('/thankyou', function () {
    return view('thankyou');
});
Route::get('/product-detail', function () {
    return view('product-detail');
})->name('product-detail');
Route::get('/product', function () {
    return view('product');
});
Route::get('/category', function () {
    return view('category');
});
Route::get('/discount', function () {
    return view('discount');
});
