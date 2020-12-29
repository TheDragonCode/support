<?php

namespace Tests;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Str;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        BaseFacade::clearResolvedInstances();

        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->destroyTempDirectory();

        parent::tearDown();
    }

    protected function tempDirectory(string $path = null): string
    {
        $prefix = $this->tempDirectoryPrefix();

        $time = Str::camel(microtime());

        $path = ltrim($path, '/');

        return implode(DIRECTORY_SEPARATOR, [$prefix, $time, $path]);
    }

    protected function fixturesDirectory(string $path = null): string
    {
        $path = ! empty($path) ? ltrim($path, '/') : '';

        return __DIR__ . '/Fixtures/' . $path;
    }

    protected function destroyTempDirectory()
    {
        $path = $this->tempDirectoryPrefix();

        if (Directory::exists($path)) {
            Directory::delete($path);
        }
    }

    protected function tempDirectoryPrefix(): string
    {
        return __DIR__ . '/tmp';
    }
}
