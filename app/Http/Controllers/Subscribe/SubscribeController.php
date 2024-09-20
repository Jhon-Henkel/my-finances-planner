<?php

namespace App\Http\Controllers\Subscribe;

use App\Services\Subscription\SubscriptionService;
use App\Tools\Response\ResponseApi;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscribeController
{
    use ValidatesRequests;

    public function __construct(protected readonly SubscriptionService $subscriptionService)
    {
    }

    public function subscribe(): JsonResponse
    {
        $data = $this->subscriptionService->createAgreement();
        return ResponseApi::renderOk($data);
    }

    public function cancel(Request $request): JsonResponse
    {
        $data = $this->validate($request, ['reason' => 'required|string']);
        $this->subscriptionService->cancelAgreement($data['reason']);
        return ResponseApi::renderOk();
    }

    public function updateAccount(Request $request)
    {
        $data = $this->validate($request, ['email' => 'required|string']);
        $this->subscriptionService->updateAccount($data['email']);
        return ResponseApi::renderOk();
    }
}
