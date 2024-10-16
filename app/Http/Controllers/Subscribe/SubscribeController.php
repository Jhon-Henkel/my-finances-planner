<?php

namespace App\Http\Controllers\Subscribe;

use App\Services\Subscription\SubscriptionService;
use App\Tools\Response\ResponseApi;
use App\Tools\Validator\MfpValidator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        MfpValidator::validateArrayData($dataDecoded, ['email' => 'required|string']);
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
