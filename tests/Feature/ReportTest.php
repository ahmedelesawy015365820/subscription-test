<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Enums\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_income_statement()
    {
        $auth = $this->authenticateAdmin();
        $tenantId = $auth['tenant']->id;

        $revenueAccount = Account::factory()->create([
            'tenant_id' => $tenantId,
            'name' => 'Subscription Revenue',
            'type' => AccountType::REVENUE
        ]);

        $entry = JournalEntry::factory()->create(['tenant_id' => $tenantId]);
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $revenueAccount->id,
            'debit' => 0,
            'credit' => 1500
        ]);

        $response = $this->getJson('/api/reports/income-statement');

        $response->assertStatus(200)
            ->assertJsonPath('data.total_revenue', '1500.00');
    }
}
