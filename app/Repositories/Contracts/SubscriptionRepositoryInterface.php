<?php

namespace App\Repositories\Contracts;

use App\Repositories\BaseRepositoryInterface;

interface SubscriptionRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveSubscriptions();
}
