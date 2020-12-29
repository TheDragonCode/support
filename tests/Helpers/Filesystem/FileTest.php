<?php

namespace Tests\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Helpers\Filesystem\File;
use SplFileInfo;
use Tests\TestCase;

final class FileTest extends TestCase
{
    public function testStore()
    {
        $path = $this->tempDirectory('foo/bar/baz/foo.txt');

        $this->assertFileDoesNotExist($path);

        $this->file()->store($path, 'foo');

        $this->assertFileExists($path);
    }

    public function testExists()
    {
        $this->assertFalse($this->file()->exists($this->fixturesDirectory()));
        $this->assertFalse($this->file()->exists($this->fixturesDirectory('foo.bar')));

        $this->assertTrue($this->file()->exists($this->fixturesDirectory('Contracts/Contract.php')));
    }

    public function testDeleteAsString()
    {
        $path = $this->tempDirectory('foo.bar');

        $this->file()->store($path, 'foo');

        $this->assertFileExists($path);

        $this->file()->delete($path);

        $this->assertFileDoesNotExist($path);
    }

    public function testDeleteAsArray()
    {
        $path1 = $this->tempDirectory('foo1');
        $path2 = $this->tempDirectory('foo2');
        $path3 = $this->tempDirectory('foo3');

        $this->file()->store($path1, 'foo');
        $this->file()->store($path2, 'foo');
        $this->file()->store($path3, 'foo');

        $this->assertFileExists($path1);
        $this->assertFileExists($path2);
        $this->assertFileExists($path3);

        $this->file()->delete([$path1, $path2, $path3]);

        $this->assertFileDoesNotExist($path1);
        $this->assertFileDoesNotExist($path2);
        $this->assertFileDoesNotExist($path3);
    }

    public function testIsFileAsString()
    {
        $path = $this->tempDirectory('foo1');

        $this->assertFalse($this->file()->isFile($path));

        $this->file()->store($path, 'foo');

        $this->assertTrue($this->file()->isFile($path));
    }

    public function testIsFileAsSplFileInfo()
    {
        $path = $this->tempDirectory('foo');

        $this->assertFalse($this->file()->isFile($path));

        $this->file()->store($path, 'foo');

        $file = new SplFileInfo($path);

        $this->assertTrue($this->file()->isFile($file));
    }

    public function testIsFileAsDirectoryIterator()
    {
        $path = $this->tempDirectory();

        $this->file()->store($path . '/foo', 'foo');

        $files = new DirectoryIterator($path);

        foreach ($files as $item) {
            $item->isDot()
                ? $this->assertFalse($this->file()->isFile($item))
                : $this->assertTrue($this->file()->isFile($item));
        }
    }

    protected function file(): File
    {
        return new File();
    }
}
