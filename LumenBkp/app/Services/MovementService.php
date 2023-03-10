<?php

namespace App\Services;

use App\DTO\MovementDTO;
use App\Repositories\MovementRepository;

class MovementService extends BasicService
{
    protected MovementRepository $repository;

    public function __construct(MovementRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): MovementRepository
    {
        return $this->repository;
    }

    /**
     * @param int $type
     * @return MovementDTO[]
     */
    public function findAllByType(int $type): array
    {
        return $this->repository->findAllByType($type);
    }
}