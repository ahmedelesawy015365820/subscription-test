<?php

use App\Http\Controllers\Administrator\Admin\AuthController;
use App\Http\Controllers\Administrator\EnumsController;
use App\Http\Controllers\Administrator\Plan\PlanController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(AdminAuth::class)->group(function () {

    // all Enums
    Route::get('get-billing-cycle', [EnumsController::class, 'getBillingCycle']);
    Route::get('get-currency', [EnumsController::class, 'getCurrency']);
    Route::get('get-payment-status', [EnumsController::class, 'getPaymentStatus']);
    Route::get('get-subscription-status', [EnumsController::class, 'getSubscriptionStatus']);

    // plan
    Route::apiResource('plans', PlanController::class);

});

