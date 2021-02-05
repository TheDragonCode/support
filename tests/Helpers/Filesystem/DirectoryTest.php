<?php

namespace Tests\Helpers\Filesystem;

use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\Directory as DirectoryFacade;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;
use Helldar\Support\Helpers\Filesystem\Directory;
use Tests\TestCase;

final class DirectoryTest extends TestCase
{
    public function testAll()
    {
        $available = ['.', '..', 'Contracts', 'Facades', 'Instances'];

        $dirs = $this->directory()->all($this->fixturesDirectory());

        foreach ($dirs as $dir) {
            in_array($dir->getFilename(), $available)
                ? $this->assertTrue($this->directory()->isDirectory($dir))
                : $this->assertFalse($this->directory()->isDirectory($dir));
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
        $path = realpath($this->fixturesDirectory('.gitkeep'));

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        $this->directory()->all($path);
    }

    public function testDelete()
    {
        $path = $this->tempDirectory();

        $this->assertFalse(DirectoryFacade::exists($path));

        $this->assertTrue($this->directory()->make($path, 777));

        $this->assertDirectoryExists($path);

        $this->assertTrue($this->directory()->delete($path));

        $this->assertFalse(DirectoryFacade::exists($path));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "foo" does not exist.');

        $this->assertTrue($this->directory()->delete('foo'));
    }

    public function testDeleteAsFile()
    {
        $path = $this->tempDirectory('.gitkeep');

        File::store($path, 'foo', 777);

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        $this->directory()->delete($path);
    }

    public function testDoesntExist()
    {
        $this->assertTrue($this->directory()->doesntExist(__DIR__ . '/../../../Foo'));
        $this->assertTrue($this->directory()->doesntExist(__DIR__ . '/../../../Instances/Foo.php'));
    }

    public function testNames()
    {
        $available = ['Contracts', 'Facades', 'Instances'];

        $names = $this->directory()->names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = ['Facades', 'Instances'];

        $names = $this->directory()->names($this->fixturesDirectory(), static function (string $name) {
            return Str::endsWith($name, 'es');
        });

        $this->assertSame($available, $names);
    }

    public function testMake()
    {
        $path = $this->tempDirectory();

        $this->assertFalse(DirectoryFacade::exists($path));

        $this->assertTrue($this->directory()->make($path, 777));

        $this->assertDirectoryExists($path);
    }

    public function testExists()
    {
        $this->assertTrue($this->directory()->exists($this->fixturesDirectory()));
    }

    public function testIsDirectory()
    {
        $this->assertTrue($this->directory()->isDirectory($this->fixturesDirectory()));

        $this->assertTrue($this->directory()->isDirectory($this->fixturesDirectory('Contracts')));
        $this->assertTrue($this->directory()->isDirectory($this->fixturesDirectory('Instances')));

        $this->assertFalse($this->directory()->isDirectory($this->fixturesDirectory('Contracts/Contract.php')));
        $this->assertFalse($this->directory()->isDirectory($this->fixturesDirectory('Instances/Foo.php')));
    }

    public function testValidateSuccess()
    {
        $this->directory()->validate($this->fixturesDirectory());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        $this->directory()->validate($this->fixturesDirectory('foo/bar'));
    }

    protected function directory(): Directory
    {
        return new Directory();
    }
}
