<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Subscription;
use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $subscriptions = Subscription::with(['plan', 'customer'])->get();

        foreach ($subscriptions as $subscription) {
            $plan = $subscription->plan;

            // Create invoice
            $invoice = Invoice::create([
                'tenant_id'       => $subscription->tenant_id,
                'customer_id'     => $subscription->customer_id,
                'subscription_id' => $subscription->id,
                'amount'          => $plan->price,
                'status'          => InvoiceStatus::UNPAID->value,
                'due_date'        => Carbon::now()->addDays(7),
            ]);

            // Accounting entry: Debit AR / Credit Deferred Revenue
            $arAccount = Account::where('tenant_id', $subscription->tenant_id)
                ->where('name', 'Accounts Receivable')->first();
            $deferredAccount = Account::where('tenant_id', $subscription->tenant_id)
                ->where('name', 'Deferred Revenue')->first();

            if ($arAccount && $deferredAccount) {
                $entry = JournalEntry::create([
                    'tenant_id'   => $subscription->tenant_id,
                    'description' => "Invoice #{$invoice->id} for Subscription #{$subscription->id}",
                    'date'        => Carbon::now(),
                ]);

                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $arAccount->id,
                    'debit'            => $plan->price,
                    'credit'           => 0,
                ]);

                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $deferredAccount->id,
                    'debit'            => 0,
                    'credit'           => $plan->price,
                ]);
            }
        }
    }
}
