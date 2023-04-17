<?php

namespace App\Services;

use App\Repositories\CreditCardRepository;

class CreditCardService extends BasicService
{
    protected CreditCardRepository $repository;

    public function __construct(CreditCardRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): CreditCardRepository
    {
        return $this->repository;
    }
}