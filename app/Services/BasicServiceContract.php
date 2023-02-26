<?php

namespace App\Services;

use Illuminate\Http\Request;

interface BasicServiceContract
{
    public function findAll();
    public function findById(int $id);
    public function insert($request);
    public function update(int $id, $request);
    public function deleteById(int $id);
}
