<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment/callback/easypaisa', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'easypaisa'])->name('api.payment.callback.easypaisa');
Route::post('/payment/callback/jazzcash', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'jazzcash'])->name('api.payment.callback.jazzcash');
Route::post('/payment/callback/paypal', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'paypal'])->name('api.payment.callback.paypal');
Route::post('/payment/callback/stripe', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'stripe'])->name('api.payment.callback.stripe');
Route::post('/payment/callback/wise', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'wise'])->name('api.payment.callback.wise');
Route::post('/payment/callback/payoneer', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'payoneer'])->name('api.payment.callback.payoneer');
