<?php


namespace App\Repositories\Administrator\Plan;

use App\Models\Plan;
use App\Dtos\Administrator\Plan\PlanDto;

class PlanRepository implements  PlanRepositoryInterface
{

    public function index()
    {
        return Plan::latest()->paginate(10);
    }

    public function find($id)
    {
        return Plan::findOrFail($id);
    }

    public function create(PlanDto $dto)
    {
        return Plan::create($dto->toDatabase());
    }

    public function update($id, PlanDto $dto)
    {
        $plan = $this->find($id);
        $plan->update($dto->toDatabase());
        return $plan;
    }

    public function delete($id)
    {
        $plan = $this->find($id);
        return $plan->delete();
    }

}
