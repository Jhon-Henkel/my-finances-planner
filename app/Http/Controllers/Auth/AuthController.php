<?php

namespace App\Http\Controllers\Auth;

use App\Enums\BasicFieldsEnum;
use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use App\Http\Response\ResponseError;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Tools\Auth\JwtTools;
use App\Tools\ErrorReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function auth(Request $request): JsonResponse
    {
        $data = $request->all();
        $authService = app(AuthService::class);
        $user = $authService->findUserForAuth($data[BasicFieldsEnum::EMAIL]);
        if (! $user) {
            $message = 'Usuário ou senha incorreto!';
            return ResponseError::responseError($message, ResponseAlias::HTTP_UNAUTHORIZED);
        }
        $loginCode = $authService->validateLogin($user, $data[BasicFieldsEnum::PASSWORD]);
        if ($loginCode === AuthService::OK_CODE) {
            $this->login($user);
            $authService->saveAccessLog($user, 1, 'Logado com sucesso');
            return response()->json($authService->makeAuthUserResponseData($user), ResponseAlias::HTTP_OK);
        } elseif ($loginCode === AuthService::INACTIVE_USER_CODE) {
            $message = 'Usuário inativo!';
            $authService->saveAccessLog($user, 0, $message);
            return ResponseError::responseError($message, ResponseAlias::HTTP_FORBIDDEN);
        } elseif ($loginCode === AuthService::INVALID_LOGIN_OR_PASSWORD_CODE) {
            $message = 'Usuário ou senha incorreto!';
            $authService->saveAccessLog($user, 0, $message);
            return ResponseError::responseError($message, ResponseAlias::HTTP_UNAUTHORIZED);
        } else {
            $message = 'Erro inesperado ao realizar login!';
            $authService->saveAccessLog($user, 0, $message);
            ErrorReport::report(new UserException($message));
            return ResponseError::responseError($message, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verifyIsAuthenticated(): JsonResponse
    {
        $authentication = $this->validateJWT();
        if ($authentication && $this->checkAuth()) {
            return response()->json(['isAuthenticated' => true], ResponseAlias::HTTP_OK);
        }
        return response()->json(null, ResponseAlias::HTTP_UNAUTHORIZED);
    }

    /** @codeCoverageIgnore */
    protected function validateJWT(): bool
    {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        return (bool)JwtTools::validateJWT($authorization);
    }

    /** @codeCoverageIgnore */
    protected function login(User $user): void
    {
        Auth::login($user);
    }

    /** @codeCoverageIgnore */
    public function logout(): JsonResponse
    {
        Auth::logout();
        Cache::clear();
        return response()->json([BasicFieldsEnum::MESSAGE => 'Logout realizado com sucesso']);
    }

    /** @codeCoverageIgnore */
    protected function checkAuth(): bool
    {
        return Auth::check();
    }
}