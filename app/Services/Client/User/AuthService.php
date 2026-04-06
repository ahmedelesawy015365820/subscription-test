<?php


namespace App\Services\Client\User;

use App\Dtos\Client\User\LoginDto;
use App\Dtos\Client\User\RegisterDto;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Client\User\AuthRepositoryInterface;
use App\Repositories\Client\Plan\PlanRepositoryInterface;
use App\Repositories\Client\Subscription\SubscriptionRepositoryInterface;

class AuthService extends BaseService
{

    public function __construct(
        private AuthRepositoryInterface $authRepo,
        private PlanRepositoryInterface $planRepo,
        private SubscriptionRepositoryInterface $subscriptionRepo,
    ) {}

    public function register(RegisterDto $data)
    {
        return $this->execute(function () use ($data) {

            $user = $this->authRepo->create($data);
            $token = $user->createToken('admin_token')->plainTextToken;

            $plan = $this->planRepo->getFreePlan();

            if($plan){
                $this->subscriptionRepo->createFreeSubscription($user,$plan);
            }

            return compact('user', 'token');
        });
    }

    public function login(LoginDTO $data)
    {
        return $this->execute(function () use ($data) {
            $user = $this->authRepo->findByEmail($data->email);

            if (!$user || !Hash::check($data->password, $user->password)) {
                return response()->json(['status' => false, 'message' => 'Invalid credentials'], 400);
            }

            $token = $user->createToken('admin_token')->plainTextToken;

            return compact('user', 'token');
        });
    }

}
