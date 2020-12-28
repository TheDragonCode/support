<?php

namespace Tests\Facades\Helpers\Filesystem;

use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Str;
use Tests\TestCase;

final class DirectoryTest extends TestCase
{
    public function testAll()
    {
        $available = ['Contracts', 'Instances', '.gitignore'];

        $dirs = Directory::all(__DIR__ . '/../../../Fixtures');

        foreach ($dirs as $dir) {
            if (! $dir->isDot()) {
                $this->assertTrue(in_array($dir->getFilename(), $available));
            }
        }
    }

    public function testAllDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "foo" does not exist.');

        Directory::all('foo');
    }

    public function testAsFile()
    {
        $path = realpath(__DIR__ . '/../../../Fixtures/.gitignore');

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        Directory::all($path);
    }

    public function testDelete()
    {
        $path = __DIR__ . '/../../../Fixtures/Temp/' . Str::camel(microtime());

        $this->assertTrue(Directory::doesntExist($path));
        $this->assertTrue(Directory::make($path));
        $this->assertTrue(Directory::exists($path));
        $this->assertTrue(Directory::delete($path));
        $this->assertTrue(Directory::doesntExist($path));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "foo" does not exist.');

        Directory::delete('foo');
    }

    public function testDeleteAsFile()
    {
        $path = realpath(__DIR__ . '/../../../Fixtures/.gitignore');

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        Directory::delete($path);
    }

    public function testDoesntExist()
    {
        $this->assertTrue(Directory::doesntExist(__DIR__ . '/../../../Foo'));
        $this->assertTrue(Directory::doesntExist(__DIR__ . '/../../../Instances/Foo.php'));
    }

    public function testNames()
    {
        $available = ['Contracts', 'Instances'];

        $names = Directory::names(__DIR__ . '/../../../Fixtures');

        $this->assertSame($available, $names);
    }

    public function testMake()
    {
        $path = __DIR__ . '/../../../Fixtures/Temp/' . Str::camel(microtime());

        $this->assertTrue(Directory::doesntExist($path));
        $this->assertTrue(Directory::make($path));
        $this->assertTrue(Directory::exists($path));
    }

    public function testExists()
    {
        $this->assertTrue(Directory::exists(__DIR__ . '/../../../Fixtures'));
    }
}
