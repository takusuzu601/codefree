<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Livewire\ShoppingCart;
use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\PaymantOrder;
use App\Models\Order;


Route::get('/', WelcomeController::class);

Route::get('search', SearchController::class)->name('search');

Route::get(
    'categories/{category}',
    [CategoryController::class, 'show']
)->name('categories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');

Route::middleware(['auth'])->group(function(){

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('orders/create', CreateOrder::class)->name('orders.create');

    Route::get('orders/{order}/payment', PaymantOrder::class)->name('orders.paymant');

    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

});


