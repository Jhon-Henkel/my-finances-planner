<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

interface BasicControllerContract
{
    public function index(): JsonResponse;
    public function show(int $id): JsonResponse;
    public function insert(Request $request): JsonResponse;
    public function update(int $id, Request $request): JsonResponse;
    public function delete(int $id): Response|JsonResponse|ResponseFactory;
}
