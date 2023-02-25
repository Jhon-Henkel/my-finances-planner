<?php

namespace App\Repositories;

class BasicRepository
{
    public function findAll()
    {
        return $this->model->all();
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function insert($item)
    {
        return $this->model->create($item->all());
    }

    public function update(int $id, $item)
    {
        return $this->model->where('id', $id)->update(($item->all()));
    }

    public function deleteById(int $id)
    {
        $teste = $this->model->find($id);
        return $teste->delete();
    }

    public function findByName(string $name): mixed
    {
        return $this->model->where('name', $name)->get();
    }
}
