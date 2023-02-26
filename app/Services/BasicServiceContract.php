<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

interface BasicServiceContract
{
    public function findAll();
    public function findById(int $id);
    public function insert($request);
    public function update(int $id, $request);
    public function deleteById(int $id);
    public function isInvalidRequest(Request $request, array $rules): MessageBag|bool;
}
