<?php

namespace App\Providers;


use App\Repositories\Administrator\Admin\AuthRepository;
use App\Repositories\Administrator\Admin\AuthRepositoryInterface;
use App\Repositories\Administrator\Plan\PlanRepository;
use App\Repositories\Administrator\Plan\PlanRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Repositories\Client\User\AuthRepository as AuthUserRepository;
use App\Repositories\Client\User\AuthRepositoryInterface as AuthUserRepositoryInterface;
use App\Repositories\Client\Plan\PlanRepository as PlanUserRepository;
use App\Repositories\Client\Plan\PlanRepositoryInterface as PlanUserRepositoryInterface;
use App\Repositories\Client\Subscription\SubscriptionRepository;
use App\Repositories\Client\Subscription\SubscriptionRepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        // dashboard
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        // client
        $this->app->bind(PlanUserRepositoryInterface::class, PlanUserRepository::class);
        $this->app->bind(AuthUserRepositoryInterface::class, AuthUserRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
