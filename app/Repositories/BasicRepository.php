<?php

namespace App\Repositories;

use App\Enums\BasicFieldsEnum;

abstract class BasicRepository implements BasicRepositoryContract
{
    protected abstract function getModel();
    protected abstract function getResource();

    public function findAll(): array
    {
        $itens = $this->getModel()->all();
        return $itens ? $this->getResource()->arrayToDtoItens($itens->toArray()) : array();
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
        $this->getModel()->where(BasicFieldsEnum::ID, $id)->update($array);
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
        $item = $this->getModel()->where(BasicFieldsEnum::NAME, $name)->get();
        return $item ? $this->getResource()->arrayToDtoItens($item->toArray()) : null;
    }
}