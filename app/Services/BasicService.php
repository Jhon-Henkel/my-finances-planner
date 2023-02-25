<?php

namespace App\Services;

use Illuminate\Http\Request;

abstract class BasicService
{
    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function insert(Request $request)
    {
        return $this->repository->insert($request);
    }

    public function update(int $id, Request $request)
    {
        return $this->repository->update($id, $request);
    }

    public function deleteById(int $id)
    {
        return $this->repository->deleteById($id);
    }
}
