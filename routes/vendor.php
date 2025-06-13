<?php

use App\Http\Controllers\Api\Vendor\ProductController;
use App\Http\Controllers\Api\Vendor\ServiceController;
use App\Http\Controllers\Api\Vendor\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::prefix('vendor')->group(function () {


    Route::prefix('store')->controller(StoreController::class)->group(function () {
        Route::post('/update/{vendor}', 'update');
    });


    Route::prefix('services')->controller(ServiceController::class)->group(function () {
        Route::get('/services-of-vendor', 'index');
        // Route::get('/all-services', 'getAllServices')->withoutMiddleware('is_vendor');
        Route::post('/store', 'store');
        Route::get('/single-service/{id}', 'show');
        Route::post('/update/{service}', 'update');
        Route::post('/update-status/{service}', 'updateStatus');
    });


    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/products-of-vendor', 'index');
        // Route::get('/all-products', 'getAllProducts')->withoutMiddleware('is_vendor');
        Route::post('/store', 'store');
        Route::get('/single-product/{id}', 'show');
        Route::post('/update/{product}', 'update');
        Route::post('/update-status/{product}', 'updateStatus');
        Route::post('/delete/{product}', 'destroy');
    });
});
