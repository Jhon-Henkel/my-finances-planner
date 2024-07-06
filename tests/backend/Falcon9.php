<?php

namespace Tests\backend;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class Falcon9 extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;
}
