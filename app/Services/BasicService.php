<?php

namespace App\Services;

abstract class BasicService implements BasicServiceContract
{
    protected abstract function getRepository();

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function findById(int $id)
    {
        return $this->getRepository()->findById($id);
    }

    public function insert($request)
    {
        return $this->getRepository()->insert($request);
    }

    public function update(int $id, $request)
    {
        return $this->getRepository()->update($id, $request);
    }

    public function deleteById(int $id)
    {
        return $this->getRepository()->deleteById($id);
    }
}
