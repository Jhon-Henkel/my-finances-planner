<?php

namespace App\Services;

use App\Repositories\CreditCardTransactionRepository;

class CreditCardTransactionService extends BasicService
{
    protected CreditCardTransactionRepository $repository;

    public function __construct(CreditCardTransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getRepository(): CreditCardTransactionRepository
    {
        return $this->repository;
    }
}