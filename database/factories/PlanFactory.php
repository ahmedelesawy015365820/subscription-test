<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Tenant;
use App\Enums\BillingCycle;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'tenant_id'     => Tenant::factory(),
            'name'          => 'Plan ' . fake()->word(),
            'price'         => 29.99,
            'billing_cycle' => BillingCycle::MONTHLY,
        ];
    }
}
