<?php

namespace App\Http\Controllers\Payment;

use App\Services\PaymentMethod\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController
{
    protected array $rules = [];

    public function __construct(protected readonly PaymentService $paymentService)
    {
    }

    public function payPlan(Request $request): JsonResponse
    {
        $data = $request->all();
        $this->paymentService->paySubscribe('', '');
        return response()->json(['message' => 'Payment successful']); // todo - usar response api
    }
}
