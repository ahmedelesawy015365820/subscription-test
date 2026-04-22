<?php

namespace App\Services;

use App\Repositories\Contracts\PlanRepositoryInterface;
use App\Dtos\PlanDTO;

class PlanService extends BaseService
{
    protected PlanRepositoryInterface $planRepository;

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function getAllPlans()
    {
        return $this->planRepository->all();
    }

    public function getPlan($id)
    {
        return $this->planRepository->find($id);
    }

    public function createPlan(PlanDTO $dto)
    {
        return $this->execute(function () use ($dto) {
            return $this->planRepository->create($dto->toArray());
        });
    }

    public function updatePlan($id, PlanDTO $dto)
    {
        return $this->execute(function () use ($id, $dto) {
            return $this->planRepository->update($id, $dto->toArray());
        });
    }

    public function deletePlan($id)
    {
        return $this->execute(function () use ($id) {
            return $this->planRepository->delete($id);
        });
    }
}
