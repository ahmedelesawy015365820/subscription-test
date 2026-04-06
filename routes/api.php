<?php


use App\Http\Controllers\Client\Plan\PlanController;
use App\Http\Controllers\Client\Subscription\SubscriptionController;
use App\Http\Controllers\Client\User\AuthController;
use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Route;

// auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// plan
Route::get('plan-list', [PlanController::class, 'getList']);


Route::middleware(UserAuth::class)->group(function () {

    // subscription
    Route::post('subscription', [SubscriptionController::class, 'create']);

});


