<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Directory;
use Tests\TestCase;

class DirectoryTest extends TestCase
{
    /**
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     */
    public function testAll()
    {
        $available = ['Eloquent', 'Models'];

        $dirs = Directory::all(
            \realpath(__DIR__ . '/../../src/Laravel')
        );

        foreach ($dirs as $dir) {
            if ($dir->isDot()) {
                continue;
            }

            $this->assertTrue(\in_array($dir->getFilename(), $available));
        }
    }

    /**
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     */
    public function testNames()
    {
        $available = ['Eloquent', 'Models'];

        $names = Directory::names(
            \realpath(__DIR__ . '/../../src/Laravel')
        );

        $this->assertSame($available, $names);
    }

    /**
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     */
    public function testFiles()
    {
        $names = Directory::names(
            \realpath(__DIR__ . '/../../src/stubs')
        );

        $this->assertSame([], $names);
    }

    public function testMakeDirectory()
    {
        $path = './build/foo/bar/baz';

        $result = Directory::make($path);

        $this->assertTrue($result);
        $this->assertTrue(is_dir($path));
    }
}
