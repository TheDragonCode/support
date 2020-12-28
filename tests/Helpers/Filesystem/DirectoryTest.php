<?php

namespace Tests\Helpers\Filesystem;

use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Str;
use Helldar\Support\Helpers\Filesystem\Directory;
use Tests\TestCase;

final class DirectoryTest extends TestCase
{
    public function testAll()
    {
        $available = ['Contracts', 'Instances', '.gitignore'];

        $dirs = $this->directory()->all(__DIR__ . '/../../Fixtures');

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

        $this->directory()->all('foo');
    }

    public function testAsFile()
    {
        $path = realpath(__DIR__ . '/../../Fixtures/.gitignore');

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        $this->directory()->all($path);
    }

    public function testDelete()
    {
        $path = $this->tempDirectory(Str::camel(microtime()));

        $this->assertTrue($this->directory()->doesntExist($path));
        $this->assertTrue($this->directory()->make($path));
        $this->assertTrue($this->directory()->exists($path));
        $this->assertTrue($this->directory()->delete($path));
        $this->assertTrue($this->directory()->doesntExist($path));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "foo" does not exist.');

        $this->directory()->delete('foo');
    }

    public function testDeleteAsFile()
    {
        $path = realpath(__DIR__ . '/../../Fixtures/.gitignore');

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        $this->directory()->delete($path);
    }

    public function testDoesntExist()
    {
        $this->assertTrue($this->directory()->doesntExist(__DIR__ . '/../../Foo'));
        $this->assertTrue($this->directory()->doesntExist(__DIR__ . '/../../Instances/Foo.php'));
    }

    public function testNames()
    {
        $available = ['Contracts', 'Instances'];

        $names = $this->directory()->names(__DIR__ . '/../../Fixtures');

        $this->assertSame($available, $names);
    }

    public function testMake()
    {
        $path = $this->tempDirectory(Str::camel(microtime()));

        $this->assertTrue($this->directory()->doesntExist($path));
        $this->assertTrue($this->directory()->make($path));
        $this->assertTrue($this->directory()->exists($path));
    }

    public function testExists()
    {
        $this->assertTrue($this->directory()->exists(__DIR__ . '/../../Fixtures'));
    }

    protected function directory(): Directory
    {
        return new Directory();
    }
}
