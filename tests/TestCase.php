<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function tempDirectory(string $path): string
    {
        return __DIR__ . '/Temp/' . ltrim($path, '/');
    }
}
