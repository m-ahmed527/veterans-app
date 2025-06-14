<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\ProductController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





// Route::get('/test', function (Request $request) {
//     return "Hello, this is a test route!";
// });


Route::get('/user', function (Request $request) {
    try {
        $user = $request->user()->fresh();
        return responseSuccess('User found successfully', $user);
    } catch (\Exception $e) {
        return responseError('Something went wrong', 500);
    }
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('/register',  'register');
    Route::post('/verify-otp',  'verifyOtp');
    Route::post('/resend-otp',  'resendOtp');
    Route::post('/login',  'login');
    Route::post('/logout',  'logout')->middleware('auth:sanctum');
    Route::post('/forgot-password',  'forgotPassword');
    Route::post('/verify-reset-token',  'verifyResetToken');
    Route::post('/reset-password',  'resetPassword');
});
Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [EmailVerificationController::class, 'resend']);

Route::middleware('auth:sanctum')->controller(ProfileController::class)->group(function () {
    Route::post('/edit/profile/{user}', 'update');
});

Route::middleware('auth:sanctum')->prefix('services')->controller(ServiceController::class)->group(function () {
    Route::get('/all-services', 'getAllServices')->withoutMiddleware('is_vendor');
    Route::get('/single-service/{id}', 'show')->withoutMiddleware('is_vendor');
});


Route::middleware('auth:sanctum')->prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('/all-products', 'getAllProducts')->withoutMiddleware('is_vendor');
    Route::get('/single-product/{id}', 'show')->withoutMiddleware('is_vendor');
});


Route::middleware('auth:sanctum')->prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/get-cart', 'index');
    Route::post('/add-to-cart', 'store');
    Route::post('/update-cart', 'store');
    Route::post('/remove-from-cart', 'removeFromCart');
    Route::post('/clear-cart', 'destroy');
});
