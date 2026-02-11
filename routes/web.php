<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
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
