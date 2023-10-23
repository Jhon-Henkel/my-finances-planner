<?php

namespace App\Services\CreditCard;

use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Services\BasicService;

class CreditCardMovementService extends BasicService
{
    protected CreditCardMovementRepository $repository;

    public function __construct(CreditCardMovementRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): CreditCardMovementRepository
    {
        return $this->repository;
    }
}