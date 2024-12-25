<?php

use Illuminate\Support\Facades\Route;

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
