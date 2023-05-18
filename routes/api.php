<?php

use Illuminate\Support\Facades\Route;

Route::get('store/{id}', [
    \App\Http\Controllers\Api\StoreController::class,
    'show'
]);

Route::get('products', [
    \App\Http\Controllers\Api\ProductsController::class,
    'index'
]);

Route::get('products/{id}', [
    \App\Http\Controllers\Api\ProductsController::class,
    'show'
]);


Route::group(
    [
        'prefix' => 'auth',
    ],
    function ($router) {
        Route::post('signup', [
            \App\Http\Controllers\Api\AuthController::class,
            'signup',
        ]);
        Route::post('signin', [
            \App\Http\Controllers\Api\AuthController::class,
            'signin',
        ]);
    }
);

Route::group(
    [
        'middleware' => 'jwt',
    ],
    function ($router) {
        Route::post('auth/signout', [
            \App\Http\Controllers\Api\AuthController::class,
            'signout',
        ]);

        Route::post('store', [
            \App\Http\Controllers\Api\StoreController::class,
            'create'
        ]);

        Route::post('products', [
            \App\Http\Controllers\Api\ProductsController::class,
            'create'
        ]);

        Route::get('my-products', [
            \App\Http\Controllers\Api\ProductsController::class,
            'myProducts'
        ]);

        Route::put('shopping-cart/{product_id}', [
            \App\Http\Controllers\Api\ShoppingCartController::class,
            'update'
        ]);

        Route::delete('shopping-cart/{id}', [
            \App\Http\Controllers\Api\ShoppingCartController::class,
            'delete'
        ]);

        Route::get('shopping-cart', [
            \App\Http\Controllers\Api\ShoppingCartController::class,
            'index'
        ]);
    }
);
