<?php

namespace App\Services;

use App\Models\Account;
use App\Models\JournalEntryLine;

class ReportService extends BaseService
{
    public function getIncomeStatement(): array
    {
        $revenueAccount = Account::where('name', 'Subscription Revenue')->first();

        $totalRevenue = 0;
        if ($revenueAccount) {
            $totalRevenue = JournalEntryLine::where('account_id', $revenueAccount->id)
                ->sum('credit');
        }

        return [
            'subscription_revenue' => $totalRevenue,
            'total_revenue' => $totalRevenue,
        ];
    }

    public function getBalanceSheet(): array
    {
        $cashAccount    = Account::where('name', 'Cash')->first();
        $arAccount      = Account::where('name', 'Accounts Receivable')->first();
        $deferredAccount = Account::where('name', 'Deferred Revenue')->first();

        $cash = 0;
        $accountsReceivable = 0;
        $deferredRevenue = 0;

        if ($cashAccount) {
            $cash = JournalEntryLine::where('account_id', $cashAccount->id)->sum('debit')
                  - JournalEntryLine::where('account_id', $cashAccount->id)->sum('credit');
        }

        if ($arAccount) {
            $accountsReceivable = JournalEntryLine::where('account_id', $arAccount->id)->sum('debit')
                                - JournalEntryLine::where('account_id', $arAccount->id)->sum('credit');
        }

        if ($deferredAccount) {
            $deferredRevenue = JournalEntryLine::where('account_id', $deferredAccount->id)->sum('credit')
                             - JournalEntryLine::where('account_id', $deferredAccount->id)->sum('debit');
        }

        return [
            'assets' => [
                'cash' => $cash,
                'accounts_receivable' => $accountsReceivable,
            ],
            'liabilities' => [
                'deferred_revenue' => $deferredRevenue,
            ],
        ];
    }
}
