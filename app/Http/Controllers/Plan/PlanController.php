<?php

namespace App\Http\Controllers\Plan;

use App\Exceptions\NotImplementedException;
use App\Http\Controllers\BasicController;
use App\Resources\Plan\PlanResource;
use App\Services\Database\DatabaseConnectionService;
use App\Services\User\PlanService;
use Illuminate\Http\JsonResponse;

class PlanController extends BasicController
{
    public function __construct(
        protected readonly PlanService $planService,
        protected readonly PlanResource $planResource
    ) {
    }

    protected function rulesInsert(): array
    {
        throw new NotImplementedException();
    }

    protected function rulesUpdate(): array
    {
        throw new NotImplementedException();
    }

    protected function getService(): PlanService
    {
        return $this->planService;
    }

    protected function getResource(): PlanResource
    {
        return $this->planResource;
    }

    public function index(): JsonResponse
    {
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();
        return parent::index();
    }
}
