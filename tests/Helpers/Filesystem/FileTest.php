<?php

namespace Tests\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Exceptions\FileNotFoundException;
use Helldar\Support\Helpers\Filesystem\File;
use SplFileInfo;
use Tests\TestCase;

final class FileTest extends TestCase
{
    public function testStore()
    {
        $path = $this->tempDirectory('foo/bar/baz/foo.txt');

        $this->assertFalse($this->file()->exists($path));

        $this->file()->store($path, 'foo', 777);

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

        $this->file()->store($path, 'foo', 777);

        $this->assertFileExists($path);

        $this->file()->delete($path);

        $this->assertFalse($this->file()->exists($path));
    }

    public function testDeleteAsArray()
    {
        $path1 = $this->tempDirectory('foo1');
        $path2 = $this->tempDirectory('foo2');
        $path3 = $this->tempDirectory('foo3');

        $this->file()->store($path1, 'foo', 777);
        $this->file()->store($path2, 'foo', 777);
        $this->file()->store($path3, 'foo', 777);

        $this->assertFileExists($path1);
        $this->assertFileExists($path2);
        $this->assertFileExists($path3);

        $this->file()->delete([$path1, $path2, $path3]);

        $this->assertFalse($this->file()->exists($path1));
        $this->assertFalse($this->file()->exists($path2));
        $this->assertFalse($this->file()->exists($path3));
    }

    public function testIsFileAsString()
    {
        $path = $this->tempDirectory('foo1');

        $this->assertFalse($this->file()->isFile($path));

        $this->file()->store($path, 'foo', 777);

        $this->assertTrue($this->file()->isFile($path));
    }

    public function testIsFileAsSplFileInfo()
    {
        $path = $this->tempDirectory('foo');

        $this->assertFalse($this->file()->isFile($path));

        $this->file()->store($path, 'foo', 777);

        $file = new SplFileInfo($path);

        $this->assertTrue($this->file()->isFile($file));
    }

    public function testIsFileAsDirectoryIterator()
    {
        $path = $this->tempDirectory();

        $this->file()->store($path . '/foo', 'foo', 777);

        $files = new DirectoryIterator($path);

        foreach ($files as $item) {
            $item->isDot()
                ? $this->assertFalse($this->file()->isFile($item))
                : $this->assertTrue($this->file()->isFile($item));
        }
    }

    public function testValidateSuccess()
    {
        $this->file()->validate($this->fixturesDirectory('.gitkeep'));

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(FileNotFoundException::class);

        $this->file()->validate($this->fixturesDirectory('foo/bar'));
    }

    protected function file(): File
    {
        return new File();
    }
}
