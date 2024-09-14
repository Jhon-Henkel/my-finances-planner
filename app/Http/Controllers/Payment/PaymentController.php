<?php

namespace App\Http\Controllers\Payment;

use App\Services\PaymentMethod\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController
{
    protected array $rules = [];

    public function __construct(protected readonly PaymentService $paymentService)
    {
    }

    public function payPlan(): JsonResponse
    {
        $this->paymentService->createAgreement();
        return response()->json(['message' => 'Payment successful']); // todo - usar response api
    }
}
