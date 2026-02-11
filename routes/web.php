<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/account', function () {
    return view('admin.account.account');
});
Route::get('/add-account', function () {
    return view('admin.account.add-account');
});
Route::get('/edit-account', function () {
    return view('admin.account.edit-account');
});

Route::get('/product', function () {
    return view('admin.product.product');
});
Route::get('/add-product', function () {
    return view('admin.product.add-product');
});
Route::get('/edit-product', function () {
    return view('admin.product.edit-product');
});
Route::get('/transaction', function () {
    return view('admin.transaction.transaction');
});
Route::get('/nota-admin', function () {
    return view(view: 'admin.transaction.nota');
});

Route::get('/stock', function () {
    return view('admin.stock.stock');
});
Route::get('/add-stock', function () {
    return view('admin.stock.add-stock');
});
Route::get('/edit-stock', function () {
    return view('admin.stock.edit-stock');
});


// customer root

Route::get('/catalog', function () {
    return view('customer.catalog');
});
Route::get('/cart-list', function () {
    return view('customer.cart');
});
Route::get('/history', function () {
    return view('customer.history');
});
Route::get('/nota', function () {
    return view('customer.nota');
});