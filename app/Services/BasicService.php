<?php

namespace App\Services;

use App\DTO\Date\DatePeriodDTO;

abstract class BasicService
{
    abstract protected function getRepository();

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function findOne()
    {
        return $this->getRepository()->findOne();
    }

    public function findById(int $id)
    {
        return $this->getRepository()->findById($id);
    }

    public function insert($item)
    {
        return $this->getRepository()->insert($item);
    }

    public function update(int $id, $item)
    {
        return $this->getRepository()->update($id, $item);
    }

    public function deleteById(int $id)
    {
        return $this->getRepository()->deleteById($id);
    }

    public function findByPeriodByDatePeriod(DatePeriodDTO $period): array
    {
        return $this->getRepository()->findByPeriod($period);
    }
}
