<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::name('admin.')->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock/store', [StockController::class, 'store'])->name('stock.store');
    Route::post('/stock/restock', [StockController::class, 'restock'])->name('stock.restock');

    Route::get('/transaksi', [OrderController::class, 'index'])->name('transaksi');
    Route::post('/transaksi/{id}/status', [OrderController::class, 'updateStatus']);
    Route::get('/nota', [OrderController::class, 'notaList'])->name('nota');
    Route::get('/nota/{id}', [OrderController::class, 'notaDetail'])->name('nota.print');
});


// customer root

Route::name('customer.')->prefix('customer')->middleware('auth')->group(function () {
    Route::get('/catalog', [CatalogController::class, 'catalog'])->name('catalog');

    Route::post('/cart/add/{id}', [CatalogController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart-list', [CatalogController::class, 'cart'])->name('cart');
    Route::post('/cart/update/{id}', [CatalogController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CatalogController::class, 'removeCart'])->name('cart.remove');
    Route::post('/checkout', [CatalogController::class, 'checkout'])->name('checkout');
    Route::get('/history', [CatalogController::class, 'history'])->name('history');
    Route::get('/nota/{id}', [CatalogController::class, 'showNota'])->name('nota.show');
});
