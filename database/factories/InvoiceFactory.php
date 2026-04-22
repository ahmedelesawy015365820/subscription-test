<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Tenant;
use App\Models\Customer;
use App\Models\Subscription;
use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'tenant_id'       => Tenant::factory(),
            'customer_id'     => Customer::factory(),
            'subscription_id' => Subscription::factory(),
            'amount'          => 29.99,
            'status'          => InvoiceStatus::UNPAID,
            'due_date'        => now()->addWeek(),
        ];
    }
}
