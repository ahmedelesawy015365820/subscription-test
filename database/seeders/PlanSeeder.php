<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        $plans = [
            [
                'name'          => 'Starter',
                'price'         => 9.99,
                'billing_cycle' => \App\Enums\BillingCycle::MONTHLY->value,
            ],
            [
                'name'          => 'Professional',
                'price'         => 29.99,
                'billing_cycle' => \App\Enums\BillingCycle::MONTHLY->value,
            ],
            [
                'name'          => 'Enterprise',
                'price'         => 99.99,
                'billing_cycle' => \App\Enums\BillingCycle::MONTHLY->value,
            ],
            [
                'name'          => 'Starter Annual',
                'price'         => 99.90,
                'billing_cycle' => \App\Enums\BillingCycle::YEARLY->value,
            ],
            [
                'name'          => 'Professional Annual',
                'price'         => 299.90,
                'billing_cycle' => \App\Enums\BillingCycle::YEARLY->value,
            ],
        ];

        foreach ($tenants as $tenant) {
            foreach ($plans as $plan) {
                Plan::create(array_merge($plan, ['tenant_id' => $tenant->id]));
            }
        }
    }
}
