<?php

namespace App\Services;

use App\DTO\WalletDTO;
use App\Repositories\WalletRepository;

class WalletService extends BasicService
{
    protected WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): WalletRepository
    {
        return $this->repository;
    }

    /**
     * @param int $type
     * @return WalletDTO[]
     */
    public function findAllByType(int $type): array
    {
        return $this->repository->findAllByType($type);
    }
}
