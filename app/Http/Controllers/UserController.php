<?php

namespace App\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Resources\UserResource;
use App\Services\UserService;

class UserController extends BasicController
{
    public function __construct(
        private readonly UserService $service,
        private readonly UserResource $resource,
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
}
