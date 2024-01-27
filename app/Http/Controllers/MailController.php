<?php

namespace App\Http\Controllers;

use App\Services\Mail\MailService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function __construct(private readonly MailService $service)
    {
    }

    public function sendTestEmail(): JsonResponse
    {
        if (! $this->service->isAppInDevMode()) {
            return response()->json(['message' => 'Dont in develop mode!'], Response::HTTP_BAD_REQUEST);
        }
        $this->service->sendTestEmail();
        return response()->json(['message' => 'E-mail send success!']);
    }
}