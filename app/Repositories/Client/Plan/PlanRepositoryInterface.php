<?php

namespace App\Repositories\Client\Plan;

interface PlanRepositoryInterface
{
    public function getList();
    public function find($id);
    public function getFreePlan();
}
