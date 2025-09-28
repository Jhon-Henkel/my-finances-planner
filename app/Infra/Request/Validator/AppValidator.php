<?php

namespace App\Infra\Request\Validator;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin AppValidatorReal
 */
class AppValidator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AppValidatorReal::class;
    }
}
