<?php

namespace App\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Resources\UserResource;
use App\Services\UserService;
use App\Tools\Request\RequestTools;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends BasicController
{
    public function __construct(
        private readonly UserService $service,
        private readonly UserResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        throw new NotImplementedException('Not implemented');
    }

    protected function rulesUpdate(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'string',
            'salary' => 'required|numeric',
            'marketPlannerValue' => 'numeric',
        ];
    }

    protected function getService(): UserService
    {
        return $this->service;
    }

    protected function getResource(): UserResource
    {
        return $this->resource;
    }

    public function insert(Request $request): JsonResponse
    {
        if (RequestTools::isApplicationInDemoMode()) {
            $message = 'Aplicação em mode demo não permite alterar as configurações!';
            return response()->json($message, ResponseAlias::HTTP_BAD_REQUEST);
        }
        return parent::insert($request);
    }

    public function activeUser(string $verifyHash): View
    {
        $user = $this->getService()->findByVerifyHash($verifyHash);
        if (! $user || $user->getVerifyHash() !== $verifyHash) {
            return view('activeUserFail');
        }
        $this->getService()->activeUser($user->getId());
        return view('activeUserSuccess');
    }

    /** @codeCoverageIgnore */
    public function developGetTokens(): JsonResponse
    {
        if (! RequestTools::isApplicationInDevelopMode()) {
            $message = 'Aplicação não está em modo desenvolvedor!';
            return response()->json($message, ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response()->json($this->getService()->developGetTokens(), ResponseAlias::HTTP_OK);
    }
}