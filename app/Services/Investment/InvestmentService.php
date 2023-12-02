<?php

namespace App\Services\Investment;

use App\Enums\InvestmentEnum;
use App\Factory\DataGraph\Investment\DataGraphInvestmentFactory;
use App\Repositories\Investment\InvestmentRepository;
use App\Services\BasicService;

class InvestmentService extends BasicService
{
    public function __construct(readonly private InvestmentRepository $repository)
    {
    }

    protected function getRepository(): InvestmentRepository
    {
        return $this->repository;
    }

    public function makeDataGraph(): array
    {
        $databaseData = $this->getRepository()->findAllInTypes(InvestmentEnum::getAllCdbIdTypes());
        $factory = new DataGraphInvestmentFactory();
        $factory->addLabel('CDB');
        foreach ($databaseData as $data) {
            $factory->addValue($data->getAmount());
        }
        return ['cdb' => $factory->getAllDataArray()];
    }
}