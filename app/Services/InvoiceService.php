<?php

namespace App\Services;

use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Dtos\InvoiceDTO;
use App\Enums\InvoiceStatus;
use Carbon\Carbon;

class InvoiceService extends BaseService
{
    protected InvoiceRepositoryInterface $invoiceRepository;
    protected SubscriptionRepositoryInterface $subscriptionRepository;
    protected AccountingService $accountingService;

    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        AccountingService $accountingService
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->accountingService = $accountingService;
    }

    public function getAllInvoices()
    {
        return $this->invoiceRepository->all();
    }

    public function getInvoice($id)
    {
        return $this->invoiceRepository->find($id);
    }

    public function createInvoice(InvoiceDTO $dto)
    {
        return $this->execute(function () use ($dto) {
            return $this->invoiceRepository->create($dto->toArray());
        });
    }

    public function updateInvoice($id, InvoiceDTO $dto)
    {
        return $this->execute(function () use ($id, $dto) {
            return $this->invoiceRepository->update($id, $dto->toArray());
        });
    }

    public function deleteInvoice($id)
    {
        return $this->execute(function () use ($id) {
            return $this->invoiceRepository->delete($id);
        });
    }

    public function generateInvoices()
    {
        return $this->execute(function () {
            $activeSubscriptions = $this->subscriptionRepository->getActiveSubscriptions();
            $generatedInvoices = [];

            foreach ($activeSubscriptions as $subscription) {
                // Here we create an invoice for the active subscription
                // The amount could be taken from the plan
                $plan = $subscription->plan;
                
                $invoiceData = [
                    'customer_id' => $subscription->customer_id,
                    'subscription_id' => $subscription->id,
                    'amount' => $plan->price,
                    'status' => InvoiceStatus::UNPAID->value,
                    'due_date' => Carbon::now()->addDays(7), // Example: due in 7 days
                ];

                $invoice = $this->invoiceRepository->create($invoiceData);
                $generatedInvoices[] = $invoice;

                // Step 9 logic (Accounting Entry)
                $arAccount = $this->accountingService->getOrCreateAccount('Accounts Receivable', 'Asset');
                $drAccount = $this->accountingService->getOrCreateAccount('Deferred Revenue', 'Liability');

                $this->accountingService->createJournalEntry("Invoice generation for Subscription #{$subscription->id}", [
                    [
                        'account_id' => $arAccount->id,
                        'debit' => $plan->price,
                        'credit' => 0
                    ],
                    [
                        'account_id' => $drAccount->id,
                        'debit' => 0,
                        'credit' => $plan->price
                    ]
                ]);
            }

            return $generatedInvoices;
        });
    }
}
