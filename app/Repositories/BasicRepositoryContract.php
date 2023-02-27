<?php

namespace App\Repositories;

interface BasicRepositoryContract
{
    public function findAll(): array;
    public function findById(int $id);
    public function insert($item);
    public function update(int $id, $item);
    public function deleteById(int $id);
    public function findByName(string $name);
}
