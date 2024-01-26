<?php

namespace App\Repositories;

use App\DTO\Date\DatePeriodDTO;

abstract class BasicRepository
{
    abstract protected function getModel();
    abstract protected function getResource();

    public function findAll(): array
    {
        $itens = $this->getModel()::orderBy('id', 'desc')->get();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
    }

    public function findOne()
    {
        $item = $this->getModel()::orderBy('id', 'desc')->first();
        return $item ? $this->getResource()->arrayToDto($item->toArray()) : null;
    }

    public function findAllToArray()
    {
        $itens = $this->getModel()::orderBy('id', 'desc')->get();
        return $itens->toArray();
    }

    public function findById(int $id)
    {
        $item = $this->getModel()->find($id);
        return $item ? $this->getResource()->arrayToDto($item->toArray()) : null;
    }

    public function insert($item)
    {
        $array = $this->getResource()->dtoToArray($item);
        $inserted = $this->getModel()->create($array)->toArray();
        return $this->getResource()->arrayToDto($inserted);
    }

    public function update(int $id, $item)
    {
        $array = $this->getResource()->dtoToArray($item);
        $this->getModel()->where('id', $id)->update($array);
        return $this->findById($id);
    }

    public function deleteById(int $id): bool
    {
        $item = $this->getModel()->find($id);
        $item?->delete();
        return true;
    }

    public function findByName(string $name): mixed
    {
        $item = $this->getModel()->where('name', $name)->get();
        return $item ? $this->getResource()->arrayToDtoItens($item->toArray()) : null;
    }

    public function findAllByType(int $type): array
    {
        $itens = $this->getModel()->where('type', $type)->get()->toArray();
        return $this->getResource()->arrayToDtoItens($itens);
    }

    public function findAllInTypes(array $types): array
    {
        $itens = $this->getModel()->whereIn('type', $types)->get()->toArray();
        return $this->getResource()->arrayToDtoItens($itens);
    }

    public function findByPeriod(DatePeriodDTO $period): array
    {
        $itens = $this->getModel()->select()
            ->where('created_at', '>=', $period->getStartDate())
            ->where('created_at', '<=', $period->getEndDate())
            ->orderBy('id', 'desc')
            ->get();
        return $this->getResource()->arrayToDtoItens($itens->toArray());
    }
}