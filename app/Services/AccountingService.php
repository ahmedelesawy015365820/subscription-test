<?php

namespace App\Services;

use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Account;
use Carbon\Carbon;

class AccountingService extends BaseService
{
    public function createJournalEntry(string $description, array $lines)
    {
        return $this->execute(function () use ($description, $lines) {
            $journalEntry = JournalEntry::create([
                'description' => $description,
                'date' => Carbon::now(),
            ]);

            foreach ($lines as $line) {
                JournalEntryLine::create([
                    'journal_entry_id' => $journalEntry->id,
                    'account_id' => $line['account_id'],
                    'debit' => $line['debit'] ?? 0,
                    'credit' => $line['credit'] ?? 0,
                ]);
            }

            return $journalEntry;
        });
    }

    public function getOrCreateAccount(string $name, string $type)
    {
        return Account::firstOrCreate(
            ['name' => $name],
            ['type' => strtolower($type)]
        );
    }
}
