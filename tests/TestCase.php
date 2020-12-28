<?php

namespace Tests;

use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Str;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function tearDown(): void
    {
        $this->destroyTempDirectory();

        parent::tearDown();
    }

    protected function tempDirectory(string $path = null): string
    {
        $time = Str::camel(microtime());
        $path = ltrim($path, '/');

        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'Temp', $time, $path]);
    }

    protected function fixturesDirectory(string $path = null): string
    {
        $path = ! empty($path) ? ltrim($path, '/') : '';

        return __DIR__ . '/Fixtures/' . $path;
    }

    protected function destroyTempDirectory()
    {
        $path = __DIR__ . '/temp';

        if (Directory::exists($path)) {
            Directory::delete($path);
        }
    }
}
