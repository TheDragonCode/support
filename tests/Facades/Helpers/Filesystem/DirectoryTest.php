<?php

namespace Tests\Facades\Helpers\Filesystem;

use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;
use Tests\TestCase;

final class DirectoryTest extends TestCase
{
    public function testAll()
    {
        $available = ['.', '..', 'Contracts', 'Exceptions', 'Facades', 'Instances', 'stubs'];

        $dirs = Directory::all($this->fixturesDirectory());

        foreach ($dirs as $dir) {
            in_array($dir->getFilename(), $available)
                ? $this->assertTrue(Directory::isDirectory($dir))
                : $this->assertFalse(Directory::isDirectory($dir));
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
        $path = realpath($this->fixturesDirectory('.gitkeep'));

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        Directory::all($path);
    }

    public function testDelete()
    {
        $path = $this->tempDirectory();

        $this->assertFalse(Directory::exists($path));

        $this->assertTrue(Directory::make($path, 777));

        $this->assertDirectoryExists($path);

        $this->assertTrue(Directory::delete($path));

        $this->assertFalse(Directory::exists($path));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "foo" does not exist.');

        $this->assertTrue(Directory::delete('foo'));
    }

    public function testDeleteAsFile()
    {
        $path = $this->tempDirectory('.gitkeep');

        File::store($path, 'foo', 777);

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
        $available = ['Contracts', 'Exceptions', 'Facades', 'Instances', 'stubs'];

        $names = Directory::names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = ['Facades', 'Instances'];

        $names = Directory::names($this->fixturesDirectory(), static function (string $name) {
            return Str::endsWith($name, 'es');
        });

        $this->assertSame($available, $names);
    }

    public function testMake()
    {
        $path = $this->tempDirectory();

        $this->assertFalse(Directory::exists($path));

        $this->assertTrue(Directory::make($path, 777));

        $this->assertDirectoryExists($path);
    }

    public function testExists()
    {
        $this->assertTrue(Directory::exists($this->fixturesDirectory()));
    }

    public function testIsDirectory()
    {
        $this->assertTrue(Directory::isDirectory($this->fixturesDirectory()));

        $this->assertTrue(Directory::isDirectory($this->fixturesDirectory('Contracts')));
        $this->assertTrue(Directory::isDirectory($this->fixturesDirectory('Instances')));

        $this->assertFalse(Directory::isDirectory($this->fixturesDirectory('Contracts/Contract.php')));
        $this->assertFalse(Directory::isDirectory($this->fixturesDirectory('Instances/Foo.php')));
    }

    public function testValidateSuccess()
    {
        Directory::validate($this->fixturesDirectory());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        Directory::validate($this->fixturesDirectory('foo/bar'));
    }

    public function testValidatedSuccess()
    {
        $path = $this->fixturesDirectory();

        $result = Directory::validated($path);

        $this->assertSame(realpath($path), $result);
    }

    public function testValidatedFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        Directory::validated($this->fixturesDirectory('foo/bar'));
    }
}
