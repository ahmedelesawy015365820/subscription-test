<?php

namespace App\Repositories\Administrator\Plan;

use App\Dtos\Administrator\Plan\PlanDto;

interface PlanRepositoryInterface
{
    public function index();
    public function find($id);
    public function create(PlanDto $data);
    public function update($id, PlanDto $data);
    public function delete($id);
}
