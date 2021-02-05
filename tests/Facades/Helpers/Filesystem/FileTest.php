<?php

namespace Tests\Facades\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Exceptions\FileNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Str;
use SplFileInfo;
use Tests\TestCase;

final class FileTest extends TestCase
{
    public function testNames()
    {
        $available = ['.bar', '.beep', '.foo', '.gitkeep'];

        $names = File::names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = ['.beep', '.gitkeep'];

        $names = File::names($this->fixturesDirectory(), static function (string $name) {
            return Str::endsWith($name, 'ep');
        });

        $this->assertSame($available, $names);
    }

    public function testStore()
    {
        $path = $this->tempDirectory('foo/bar/baz/foo.txt');

        $this->assertFalse(File::exists($path));

        File::store($path, 'foo', 777);

        $this->assertFileExists($path);
    }

    public function testExists()
    {
        $this->assertFalse(File::exists($this->fixturesDirectory()));
        $this->assertFalse(File::exists($this->fixturesDirectory('foo.bar')));

        $this->assertTrue(File::exists($this->fixturesDirectory('Contracts/Contract.php')));
    }

    public function testDeleteAsString()
    {
        $path = $this->tempDirectory('foo.bar');

        File::store($path, 'foo', 777);

        $this->assertFileExists($path);

        File::delete($path);

        $this->assertFalse(File::exists($path));
    }

    public function testDeleteAsArray()
    {
        $path1 = $this->tempDirectory('foo1');
        $path2 = $this->tempDirectory('foo2');
        $path3 = $this->tempDirectory('foo3');

        File::store($path1, 'foo', 777);
        File::store($path2, 'foo', 777);
        File::store($path3, 'foo', 777);

        $this->assertFileExists($path1);
        $this->assertFileExists($path2);
        $this->assertFileExists($path3);

        File::delete([$path1, $path2, $path3]);

        $this->assertFalse(File::exists($path1));
        $this->assertFalse(File::exists($path2));
        $this->assertFalse(File::exists($path3));
    }

    public function testIsFileAsString()
    {
        $path = $this->tempDirectory('foo1');

        $this->assertFalse(File::isFile($path));

        File::store($path, 'foo', 777);

        $this->assertTrue(File::isFile($path));
    }

    public function testIsFileAsSplFileInfo()
    {
        $path = $this->tempDirectory('foo');

        $this->assertFalse(File::isFile($path));

        File::store($path, 'foo', 777);

        $file = new SplFileInfo($path);

        $this->assertTrue(File::isFile($file));
    }

    public function testIsFileAsDirectoryIterator()
    {
        $path = $this->tempDirectory();

        File::store($path . '/foo', 'foo', 777);

        $files = new DirectoryIterator($path);

        foreach ($files as $item) {
            $item->isDot()
                ? $this->assertFalse(File::isFile($item))
                : $this->assertTrue(File::isFile($item));
        }
    }

    public function testValidateSuccess()
    {
        File::validate($this->fixturesDirectory('.gitkeep'));

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(FileNotFoundException::class);

        File::validate($this->fixturesDirectory('foo/bar'));
    }

    public function testValidatedSuccess()
    {
        $path = $this->fixturesDirectory('.gitkeep');

        $result = File::validated($path);

        $this->assertSame(realpath($path), $result);
    }

    public function testValidatedFailed()
    {
        $this->expectException(FileNotFoundException::class);

        File::validated($this->fixturesDirectory('foo/bar'));
    }
}
