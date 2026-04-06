<?php

namespace App\Observers\Administrator;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class PlanObserver
{

    public function saving(Plan $plan)
    {
        if ($plan->is_default) {
            DB::transaction(function () use ($plan) {
                Plan::where('is_default', 1)->lockForUpdate()->update(['is_default' => 0]);
                $plan->is_default = 1;
            });
        }
    }

}
