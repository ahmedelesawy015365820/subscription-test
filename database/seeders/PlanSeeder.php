<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use App\Enums\BillingCycle;
use App\Enums\Currency;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrCreate(
            ['name' => 'Free Trial'],
            [
                'price' => 0,
                'currency' => Currency::USD,
                'billing_cycle' => BillingCycle::MONTHLY,
                'days' => 7,
                'is_default' => 1,
            ]
        );
    }
}
