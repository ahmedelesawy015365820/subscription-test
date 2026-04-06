<?php


namespace App\Repositories\Client\Plan;

use App\Models\Plan;

class PlanRepository implements  PlanRepositoryInterface
{

    public function getList()
    {
        return Plan::get();
    }

    public function find($id)
    {
        return Plan::find($id);
    }

    public function getFreePlan()
    {
        return Plan::where('is_default', 1)->first();
    }

}
