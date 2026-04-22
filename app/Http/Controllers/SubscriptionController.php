<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\SubscriptionRequest;
use App\Services\SubscriptionService;
use App\Dtos\SubscriptionDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends BaseController
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Subscription::class);
        $subscriptions = $this->subscriptionService->getAllSubscriptions();
        return $this->responseJson($subscriptions, 'Subscriptions retrieved successfully.');
    }

    public function store(SubscriptionRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Subscription::class);
        $dto = new SubscriptionDTO($request->validated());
        $subscription = $this->subscriptionService->createSubscription($dto);

        return $this->responseJson($subscription, 'Subscription created successfully.', 201);
    }

    public function show($id): JsonResponse
    {
        $subscription = $this->subscriptionService->getSubscription($id);

        if (!$subscription) {
            return $this->responseJson(null, 'Subscription not found.', 404);
        }

        $this->authorize('view', $subscription);

        return $this->responseJson($subscription, 'Subscription retrieved successfully.');
    }

    public function update(SubscriptionRequest $request, $id): JsonResponse
    {
        $subscription = $this->subscriptionService->getSubscription($id);
        if (!$subscription) {
            return $this->responseJson(null, 'Subscription not found.', 404);
        }

        $this->authorize('update', $subscription);

        $dto = new SubscriptionDTO($request->validated());
        $updated = $this->subscriptionService->updateSubscription($id, $dto);

        return $this->responseJson(null, 'Subscription updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $subscription = $this->subscriptionService->getSubscription($id);
        if (!$subscription) {
            return $this->responseJson(null, 'Subscription not found.', 404);
        }

        $this->authorize('delete', $subscription);

        $this->subscriptionService->deleteSubscription($id);

        return $this->responseJson(null, 'Subscription deleted successfully.');
    }

    public function cancel($id): JsonResponse
    {
        $subscription = $this->subscriptionService->getSubscription($id);
        if (!$subscription) {
            return $this->responseJson(null, 'Subscription not found.', 404);
        }

        $this->authorize('cancel', $subscription);

        $this->subscriptionService->cancelSubscription($id);

        return $this->responseJson(null, 'Subscription canceled successfully.');
    }

    public function activate($id): JsonResponse
    {
        $subscription = $this->subscriptionService->getSubscription($id);
        if (!$subscription) {
            return $this->responseJson(null, 'Subscription not found.', 404);
        }

        $this->authorize('activate', $subscription);

        $this->subscriptionService->activateSubscription($id);

        return $this->responseJson(null, 'Subscription activated successfully.');
    }
}
