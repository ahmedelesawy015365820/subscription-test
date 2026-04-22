<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Tenant;
use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name'      => fake()->word() . ' Account',
            'type'      => AccountType::ASSET,
        ];
    }
}
