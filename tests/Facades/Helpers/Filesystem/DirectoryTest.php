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

namespace Tests\Facades\Helpers\Filesystem;

use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Facades\Helpers\Filesystem\Directory;
use DragonCode\Support\Facades\Helpers\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class DirectoryTest extends TestCase
{
    public function testAll()
    {
        $available = ['.', '..', 'Concerns', 'Contracts', 'Exceptions', 'Facades', 'Foo', 'Instances', 'stubs'];

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

    public function testEnsureDelete()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);

        $this->assertTrue(Directory::make($path1), 777);

        $this->assertDirectoryExists($path1);

        $this->assertTrue(Directory::ensureDelete($path1));
        $this->assertTrue(Directory::ensureDelete($path2));

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);
    }

    public function testEnsureDirectory()
    {
        $path = $this->tempDirectory();

        $path1 = $path . 'foo';
        $path2 = $path . 'bar';

        $this->assertTrue(Directory::doesntExist($path));
        $this->assertTrue(Directory::doesntExist($path1));
        $this->assertTrue(Directory::doesntExist($path2));

        Directory::make($path1);

        $this->assertTrue(Directory::exists($path));
        $this->assertTrue(Directory::exists($path1));
        $this->assertTrue(Directory::doesntExist($path2));

        Directory::ensureDirectory($path2);

        $this->assertTrue(Directory::exists($path));
        $this->assertTrue(Directory::exists($path1));
        $this->assertTrue(Directory::exists($path2));

        Directory::ensureDirectory($path, 0755, true);

        $this->assertTrue(Directory::exists($path));
        $this->assertTrue(Directory::doesntExist($path1));
        $this->assertTrue(Directory::doesntExist($path2));
    }

    public function testDoesntExist()
    {
        $this->assertTrue(Directory::doesntExist(__DIR__ . '/../../../Foo'));
        $this->assertTrue(Directory::doesntExist(__DIR__ . '/../../../Instances/Foo.php'));
    }

    public function testNames()
    {
        $available = ['Concerns', 'Contracts', 'Exceptions', 'Facades', 'Foo', 'Instances', 'stubs'];

        $names = Directory::names($this->fixturesDirectory());

        $this->assertSame($available, $names);
    }

    public function testNamesRecursive()
    {
        $available = [
            'Concerns',
            'Contracts',
            'Exceptions',
            'Facades',
            'Foo',
            'Foo/Bar',
            'Instances',
            'stubs',
        ];

        $names = Directory::names($this->fixturesDirectory(), null, true);

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

        Directory::validate($this->fixturesDirectory('qwe/rty'));
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

        Directory::validated($this->fixturesDirectory('qwe/rty'));
    }
}
