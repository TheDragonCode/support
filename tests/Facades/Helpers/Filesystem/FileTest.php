<?php

namespace Tests\Facades\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use SplFileInfo;
use Tests\TestCase;

final class FileTest extends TestCase
{
    public function testStore()
    {
        $path = $this->tempDirectory('foo/bar/baz/foo.txt');

        $this->assertFileDoesNotExist($path);

        File::store($path, 'foo');

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

        File::store($path, 'foo');

        $this->assertFileExists($path);

        File::delete($path);

        $this->assertFileDoesNotExist($path);
    }

    public function testDeleteAsArray()
    {
        $path1 = $this->tempDirectory('foo1');
        $path2 = $this->tempDirectory('foo2');
        $path3 = $this->tempDirectory('foo3');

        File::store($path1, 'foo');
        File::store($path2, 'foo');
        File::store($path3, 'foo');

        $this->assertFileExists($path1);
        $this->assertFileExists($path2);
        $this->assertFileExists($path3);

        File::delete([$path1, $path2, $path3]);

        $this->assertFileDoesNotExist($path1);
        $this->assertFileDoesNotExist($path2);
        $this->assertFileDoesNotExist($path3);
    }

    public function testIsFileAsString()
    {
        $path = $this->tempDirectory('foo1');

        $this->assertFalse(File::isFile($path));

        File::store($path, 'foo');

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
}
