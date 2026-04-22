<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plan\PlanRequest;
use App\Services\PlanService;
use App\Dtos\PlanDTO;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    protected PlanService $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Plan::class);
        $plans = $this->planService->getAllPlans();
        return $this->responseJson($plans, 'Plans retrieved successfully.');
    }

    public function store(PlanRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Plan::class);
        $dto = new PlanDTO($request->validated());
        $plan = $this->planService->createPlan($dto);

        return $this->responseJson($plan, 'Plan created successfully.', 201);
    }

    public function show($id): JsonResponse
    {
        $plan = $this->planService->getPlan($id);

        if (!$plan) {
            return $this->responseJson(null, 'Plan not found.', 404);
        }

        $this->authorize('view', $plan);

        return $this->responseJson($plan, 'Plan retrieved successfully.');
    }

    public function update(PlanRequest $request, $id): JsonResponse
    {
        $plan = $this->planService->getPlan($id);
        if (!$plan) {
            return $this->responseJson(null, 'Plan not found.', 404);
        }

        $this->authorize('update', $plan);

        $dto = new PlanDTO($request->validated());
        $updated = $this->planService->updatePlan($id, $dto);

        return $this->responseJson(null, 'Plan updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $plan = $this->planService->getPlan($id);
        if (!$plan) {
            return $this->responseJson(null, 'Plan not found.', 404);
        }

        $this->authorize('delete', $plan);

        $this->planService->deletePlan($id);

        return $this->responseJson(null, 'Plan deleted successfully.');
    }
}
