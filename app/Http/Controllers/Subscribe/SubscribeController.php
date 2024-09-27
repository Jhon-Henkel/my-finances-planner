<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Response\ApiResponse;
use App\Services\Subscription\SubscriptionService;
use App\Tools\Response\ResponseApi;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SubscribeController
{
    use ValidatesRequests;

    private array $paymentNotificationRules = [
        'data.object.payment_link' => 'required|string',
    ];

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
        if (isset($request->json()->all()['email'])) {
            $dataDecoded = $request->json()->all();
        } else {
            $dataDecrypted = Crypt::decryptString($request->json()->all()[0]);
            $dataDecoded = json_decode($dataDecrypted, true);
        }
        $data = $this->subscriptionService->isInvalidArrayData($dataDecoded, ['email' => 'required|string']);
        if ($data instanceof MessageBag) {
            return ApiResponse::responseError($data, ResponseAlias::HTTP_BAD_REQUEST);
        }
        $this->subscriptionService->updateAccount($dataDecoded['email']);
        return ResponseApi::renderOk();
    }

    public function paymentCompletedNotification(Request $request)
    {
        $data = $this->validate($request, $this->paymentNotificationRules);
        $this->subscriptionService->paymentCompletedNotification($data);
        return ResponseApi::renderOk();
    }
}
