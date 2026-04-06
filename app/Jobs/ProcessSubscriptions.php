<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Enums\SubscriptionStatus;

class ProcessSubscriptions implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subs = Subscription::where('status', SubscriptionStatus::TRIALING)
            ->where('ends_at', '<', now())
            ->get();

        foreach ($subs as $sub) {
            $sub->update([
                'status' => SubscriptionStatus::CANCELED
            ]);
        }

        $subs = Subscription::where('status', SubscriptionStatus::PAST_DUE)
            ->where('grace_ends_at', '<', now())
            ->get();

        foreach ($subs as $sub) {
            $sub->update([
                'status' => SubscriptionStatus::CANCELED
            ]);
        }


    }
}
