<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use App\Enums\SubscriptionStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::with('tenant')->get();

        foreach ($customers as $customer) {
            // Get a random plan for the same tenant
            $plan = Plan::where('tenant_id', $customer->tenant_id)
                ->where('billing_cycle', 'monthly')
                ->inRandomOrder()
                ->first();

            if (!$plan) continue;

            $startDate = Carbon::now()->subDays(rand(0, 30));
            $endDate   = $startDate->copy()->addMonth();

            Subscription::create([
                'tenant_id'   => $customer->tenant_id,
                'customer_id' => $customer->id,
                'plan_id'     => $plan->id,
                'start_date'  => $startDate,
                'end_date'    => $endDate,
                'status'      => SubscriptionStatus::ACTIVE->value,
            ]);
        }
    }
}
