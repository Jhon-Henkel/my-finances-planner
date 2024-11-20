<?php

namespace App\Infra\Controller\Show;

use App\Http\Controllers\Controller;
use App\Infra\Shared\UseCase\Show\IShowUseCase;

abstract class BaseShowController extends Controller
{
    abstract protected function getUseCase(): IShowUseCase;
}
