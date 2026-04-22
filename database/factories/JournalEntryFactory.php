<?php

namespace Database\Factories;

use App\Models\JournalEntry;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalEntryFactory extends Factory
{
    protected $model = JournalEntry::class;

    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'description' => 'Test Entry',
            'date'        => now(),
        ];
    }
}
