<?php


namespace App\Http\Controllers\Client\Plan;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Administrator\PlanResource;
use App\Repositories\Client\Plan\PlanRepositoryInterface;


class PlanController extends BaseController
{

    protected $planRepo;

    public function __construct(PlanRepositoryInterface $planRepo){
        $this->planRepo = $planRepo;
    }

    public function getList()
    {
        $plans = $this->planRepo->getList();
        return $this->responseJson(new PlanResource($plans), 'fetch data', 200);
    }

}
