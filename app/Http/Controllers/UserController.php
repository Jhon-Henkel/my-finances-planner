<?php

namespace App\Http\Controllers;

use App\Exceptions\NotImplementedException;
use App\Resources\UserResource;
use App\Services\UserService;
use Exception;

class UserController extends BasicController
{
    protected UserService $service;
    protected UserResource $resource;

    public function __construct(UserService $service)
    {
        $this->service = $service;
        $this->resource = app(UserResource::class);
    }

    /**
     * @throws Exception
     */
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