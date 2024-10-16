<?php

namespace App\Tools\Validator;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin MfpValidatorReal
 */
class MfpValidator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MfpValidatorReal::class;
    }
}
