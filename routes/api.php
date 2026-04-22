<?php

use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login',    [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('enums',     [\App\Http\Controllers\EnumController::class, 'index']);

// ─── Protected Routes (Sanctum + Tenant isolation via BelongsToTenant) ──────
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    // Plans
    Route::apiResource('plans', \App\Http\Controllers\PlanController::class);

    // Customers
    Route::apiResource('customers', \App\Http\Controllers\CustomerController::class);

    // Subscriptions
    Route::apiResource('subscriptions', \App\Http\Controllers\SubscriptionController::class);
    Route::post('subscriptions/{id}/cancel',   [\App\Http\Controllers\SubscriptionController::class, 'cancel']);
    Route::post('subscriptions/{id}/activate', [\App\Http\Controllers\SubscriptionController::class, 'activate']);

    // Invoices
    Route::apiResource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::post('generate-invoices', [\App\Http\Controllers\InvoiceController::class, 'generateInvoices']);

    // Payments
    Route::apiResource('payments', \App\Http\Controllers\PaymentController::class)->only(['index', 'store', 'show']);

    // Reports
    Route::get('reports/income-statement', [\App\Http\Controllers\ReportController::class, 'incomeStatement']);
    Route::get('reports/balance-sheet',    [\App\Http\Controllers\ReportController::class, 'balanceSheet']);
});
