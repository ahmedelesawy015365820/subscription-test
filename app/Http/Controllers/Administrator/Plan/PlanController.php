<?php


namespace App\Http\Controllers\Administrator\Plan;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrator\Admin\LoginRequest;
use App\Http\Requests\Administrator\Admin\RegisterRequest;
use App\Http\Requests\Administrator\Plan\PlanRequest;
use App\Http\Resources\Administrator\PlanResource;
use App\Repositories\Administrator\Plan\PlanRepositoryInterface;
use App\Services\Administrator\Admin\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanController extends BaseController
{

    protected $planRepo;

    public function __construct(PlanRepositoryInterface $planRepo){
        $this->planRepo = $planRepo;
    }

    public function index()
    {
        $plans = $this->planRepo->index();
        return $this->responseJson(PlanResource::collection($plans->items()), 'fetch data', 200,$this->getPaginates($plans));
    }

    public function store(PlanRequest $request)
    {
        $plan = $this->planRepo->create($request->toDto());
        return $this->responseJson(new PlanResource($plan), 'Created Successfully', 200);
    }

    public function show($id)
    {
        $plan = $this->planRepo->find($id);
        return $this->responseJson(new PlanResource($plan), 'fetch data', 200);
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = $this->planRepo->update($id, $request->validated());
        return $this->responseJson(new PlanResource($plan), 'Update Successfully', 200);
    }

    public function destroy($id)
    {
        $this->planRepo->delete($id);
        return $this->responseJson([], 'Deleted Successfully', 200);
    }

}
