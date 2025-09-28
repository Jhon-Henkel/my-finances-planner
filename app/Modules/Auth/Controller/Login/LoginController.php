<?php

namespace App\Modules\Auth\Controller\Login;

use App\Infra\Controller\Controller;
use App\Infra\Request\Validator\AppValidator;
use App\Infra\Response\Api\ResponseApi;
use App\Modules\Auth\UseCase\Login\LoginUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(private LoginUseCase $useCase)
    {
    }

    protected function getRules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    public function __invoke(Request $request): JsonResponse
    {
        AppValidator::validateRequest($request, $this->getRules());
        $result = $this->useCase->execute($request->input('email'), $request->input('password'));
        if (empty($result)) {
            return ResponseApi::renderInternalServerError('Erro ao fazer Login');
        }
        if ($result == 'invalid_credentials') {
            return ResponseApi::renderUnauthorized();
        }
        return ResponseApi::renderOk($result);
    }
}
