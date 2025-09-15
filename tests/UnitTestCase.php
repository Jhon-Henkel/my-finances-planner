<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;

abstract class UnitTestCase extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getAllModels(): array
    {
        $models = [];

        $path = app_path('Models');

        foreach (File::allFiles($path) as $file) {
            $relativePath = $file->getRelativePathname();
            $class = str_replace(['/', '.php'], ['\\', ''], $relativePath);
            $class = 'App\\Models\\' . $class;

            if (class_exists($class)) {
                $models[] = $class;
            }
        }

        return $models;
    }
}
