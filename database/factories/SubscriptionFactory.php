<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\Customer;
use App\Models\Plan;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'customer_id' => Customer::factory(),
            'plan_id'     => Plan::factory(),
            'start_date'  => now(),
            'status'      => SubscriptionStatus::ACTIVE,
        ];
    }
}
