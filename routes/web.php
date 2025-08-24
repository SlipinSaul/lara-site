<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [MainController::class, 'index'])->name('index');


Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::get('/categories', [MainController::class, 'categories'])->name('categories');

Route::group(['prefix'=>'basket'], function(){
    Route::group(['middleware' => 'basket_not_empty'], function () {
        Route::get('/', [BasketController::class, 'basket'])->name('basket');

        Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket.place');

        Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basket.confirm');

        Route::post('/remove/{product}', [BasketController::class, 'basketRemove'])->name('basket.remove');
    });

    Route::post('/add/{product}', [BasketController::class, 'basketAdd'])->name('basket.add');
});

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'is_admin'], function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('home');
        Route::resource('/categories', CategoryController::class);
        Route::resource('/products', ProductController::class);
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix'=>'person'], function () {
        Route::get('/orders', [App\Http\Controllers\Person\OrderController::class, 'index'])->name('person.orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Person\OrderController::class, 'show'])->name('person.orders.show');
    });
});

Route::get('/{category}', [MainController::class, 'category'])->name('category');

Route::get('/{category}/{product}', [MainController::class, 'product'])->name('product');






