<?php

namespace App\Http\Controllers\Subscribe;

use _PHPStan_eeb46c016\Nette\NotImplementedException;
use App\Http\Controllers\BasicController;
use App\Services\Subscription\SubscriptionService;
use App\Tools\Response\ResponseApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscribeController extends BasicController
{
    public function __construct(protected readonly SubscriptionService $subscribeService)
    {
    }

    protected function rulesInsert(): array
    {
        throw new NotImplementedException();
    }

    protected function rulesUpdate(): array
    {
        throw new NotImplementedException();
    }

    protected function getService()
    {
        throw new NotImplementedException();
    }

    protected function getResource()
    {
        throw new NotImplementedException();
    }

    public function subscribe(): JsonResponse
    {
        $this->subscribeService->createAgreement();
        return ResponseApi::renderOk();
    }

    public function cancel(Request $request): JsonResponse
    {
        $data = $this->validate($request, ['reason' => 'required|string']);
        $this->subscribeService->cancelAgreement($data['reason']);
        return ResponseApi::renderOk();
    }
}
