<?php

namespace App\Http\Controllers;

use App\Tools\RequestTools;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function sendTestEmail(): JsonResponse
    {
        if (! RequestTools::isApplicationInDevelopMode()) {
            return response()->json(['message' => 'Dont in develop mode!'], Response::HTTP_BAD_REQUEST);
        }
        app('App\Services\MailService')->sendTestEmail();
        return response()->json(['message' => 'E-mail send success!']);
    }
}