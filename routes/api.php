<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\User\ProfileController;
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




