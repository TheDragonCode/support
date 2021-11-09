<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Helpers\Filesystem;

use DirectoryIterator;
use DragonCode\Support\Exceptions\FileNotFoundException;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Filesystem\File;
use SplFileInfo;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function testNames()
    {
        $available = ['.bar', '.beep', '.foo', '.gitkeep'];

        $names = $this->file()->names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesRecursive()
    {
        $available = [
            '.bar',
            '.beep',
            '.foo',
            '.gitkeep',
            'Concerns/Foable.php',
            'Contracts/Contract.php',
            'Exceptions/AnyException.php',
            'Facades/NotImplement.php',
            'Facades/Resolve.php',
            'Foo/Bar/.gitkeep',
            'Instances/Arrayable.php',
            'Instances/Baq.php',
            'Instances/Bar.php',
            'Instances/Bat.php',
            'Instances/Baz.php',
            'Instances/Foo.php',
            'Instances/Psr.php',
            'stubs/custom.stub',
        ];

        $names = $this->file()->names($this->fixturesDirectory(), null, true);

        $this->assertSame($available, $names);
    }

    public function testNamesCallback()
    {
        $available = ['.beep', '.gitkeep'];

        $names = $this->file()->names($this->fixturesDirectory(), static function (string $name) {
            return Str::endsWith($name, 'ep');
        });

        $this->assertSame($available, $names);
    }

    public function testStore()
    {
        $path = $this->tempDirectory('foo/bar/baz/foo.txt');

        $this->assertFalse($this->file()->exists($path));

        $saved = $this->file()->store($path, 'foo', 777);

        $this->assertFileExists($path);
        $this->assertSame(realpath($path), $saved);
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

    public function testEnsureDeleteAsString()
    {
        $path = $this->tempDirectory('foo.bar');

        $this->file()->store($path, 'foo', 777);

        $this->assertFileExists($path);

        $this->file()->ensureDelete($path);

        $this->assertFalse($this->file()->exists($path));
    }

    public function testEnsureDeleteAsArray()
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

        $this->file()->ensureDelete([$path1, $path2, $path3]);

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

    public function testValidatedSuccess()
    {
        $path = $this->fixturesDirectory('.gitkeep');

        $result = $this->file()->validated($path);

        $this->assertSame(realpath($path), $result);
    }

    public function testValidatedFailed()
    {
        $this->expectException(FileNotFoundException::class);

        $this->file()->validated($this->fixturesDirectory('foo/bar'));
    }

    protected function file(): File
    {
        return new File();
    }
}
