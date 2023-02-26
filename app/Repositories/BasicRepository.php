<?php

namespace App\Repositories;

abstract class BasicRepository implements BasicRepositoryContract
{
    protected abstract function getModel();
    protected abstract function getResource();

    // todo os itens achados devem passar pelo resource
    public function findAll()
    {
        return $this->getModel()->all();
    }

    // todo os itens achados devem passar pelo resource
    public function findById(int $id)
    {
        return $this->getModel()->find($id);
    }

    // todo os itens criados devem passar pelo resource
    public function insert($item)
    {
        $array = $this->getResource()->dtoToArray($item);
        return $this->getModel()->create($array);
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

    // todo os itens achados devem passar pelo resource
    public function findByName(string $name): mixed
    {
        return $this->getModel()->where('name', $name)->get();
    }
}
