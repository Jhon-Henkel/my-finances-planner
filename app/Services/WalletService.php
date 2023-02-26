<?php

namespace App\Services;

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
}
