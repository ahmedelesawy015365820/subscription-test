<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::define('isAdmin', function (\App\Models\User $user) {
            return $user->role === \App\Enums\UserRole::ADMIN;
        });

        \Illuminate\Support\Facades\Gate::policy(\App\Models\Plan::class, \App\Policies\PlanPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Customer::class, \App\Policies\CustomerPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Subscription::class, \App\Policies\SubscriptionPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Invoice::class, \App\Policies\InvoicePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Payment::class, \App\Policies\PaymentPolicy::class);
    }
}
