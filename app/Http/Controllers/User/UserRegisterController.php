<?php

namespace App\Http\Controllers\User;

use App\Exceptions\NotImplementedException;
use App\Http\Controllers\BasicController;
use App\Resources\UserResource;
use App\Services\Database\DatabaseConnectionService;
use App\Services\Queue\QueueMessagesService;
use App\Services\UserService;
use App\Tools\Response\ResponseApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserRegisterController extends BasicController
{
    public function __construct(
        private readonly UserService $service,
        private readonly UserResource $resource,
        private readonly QueueMessagesService $queueMessagesService,
        private readonly DatabaseConnectionService $databaseConnectionService,
    ) {
    }

    protected function rulesInsert(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'confirmPassword' => 'required|string',
        ];
    }

    protected function rulesUpdate(): array
    {
        throw new NotImplementedException();
    }

    protected function getService(): UserService
    {
        return $this->service;
    }

    protected function getResource(): UserResource
    {
        return $this->resource;
    }

    public function registerStepZero(Request $request): JsonResponse
    {
        $this->databaseConnectionService->setMasterConnection();
        $data = $request->json()->all();
        $this->validate($request, $this->rulesInsert());
        $this->queueMessagesService->putMessageUserRegisterStepOne($data);
        return ResponseApi::renderCreated();
    }

    public function registerStepOne(Request $request): JsonResponse
    {
        $this->databaseConnectionService->setMasterConnection();
        dd($request->json()->all());
    }
}
