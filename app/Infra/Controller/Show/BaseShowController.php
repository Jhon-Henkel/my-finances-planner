<?php

namespace App\Infra\Controller\Show;

use App\Http\Controllers\Controller;
use App\Infra\UseCase\Show\IShowUseCase;

/**
 * @deprecated use BaseGetController
 */
abstract class BaseShowController extends Controller
{
    abstract protected function getUseCase(): IShowUseCase;
}
