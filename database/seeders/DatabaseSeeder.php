<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,       // 1. Create tenants + admin users
            PlanSeeder::class,         // 2. Create subscription plans per tenant
            CustomerSeeder::class,     // 3. Create customers per tenant
            SubscriptionSeeder::class, // 4. Create active subscriptions
            AccountSeeder::class,      // 5. Create chart of accounts per tenant
            InvoiceSeeder::class,      // 6. Generate invoices + accounting entries
            PaymentSeeder::class,      // 7. Process payments + accounting entries
        ]);
    }
}
