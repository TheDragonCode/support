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

use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Facades\Helpers\Filesystem\Directory as DirectoryFacade;
use DragonCode\Support\Facades\Helpers\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Filesystem\Directory;
use Tests\TestCase;

class DirectoryTest extends TestCase
{
    public function testAll()
    {
        $available = ['.', '..', 'Concerns', 'Contracts', 'Exceptions', 'Facades', 'Foo', 'Instances', 'stubs'];

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
        $this->expectExceptionMessage('Directory "qwerty" does not exist.');

        $this->directory()->all('qwerty');
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

        $this->assertDirectoryDoesNotExist($path);

        $this->assertTrue($this->directory()->make($path, 777));

        $this->assertDirectoryExists($path);

        $this->assertTrue($this->directory()->delete($path));

        $this->assertFalse($this->directory()->exists($path));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "qwe" does not exist.');

        $this->assertTrue($this->directory()->delete('qwe'));
    }

    public function testDeleteAsFile()
    {
        $path = $this->tempDirectory('.gitkeep');

        File::store($path, 'foo', 777);

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        $this->directory()->delete($path);
    }

    public function testEnsureDelete()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);

        $this->assertTrue($this->directory()->make($path1), 777);

        $this->assertDirectoryExists($path1);

        $this->assertTrue($this->directory()->ensureDelete($path1));
        $this->assertTrue($this->directory()->ensureDelete($path2));

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);
    }

    public function testEnsureDirectory()
    {
        $path = $this->tempDirectory();

        $path1 = $path . 'foo';
        $path2 = $path . 'bar';

        $this->assertTrue($this->directory()->doesntExist($path));
        $this->assertTrue($this->directory()->doesntExist($path1));
        $this->assertTrue($this->directory()->doesntExist($path2));

        $this->directory()->make($path1);

        $this->assertTrue($this->directory()->exists($path));
        $this->assertTrue($this->directory()->exists($path1));
        $this->assertTrue($this->directory()->doesntExist($path2));

        $this->directory()->ensureDirectory($path2);

        $this->assertTrue($this->directory()->exists($path));
        $this->assertTrue($this->directory()->exists($path1));
        $this->assertTrue($this->directory()->exists($path2));

        $this->directory()->ensureDirectory($path, 0755, true);

        $this->assertTrue($this->directory()->exists($path));
        $this->assertTrue($this->directory()->doesntExist($path1));
        $this->assertTrue($this->directory()->doesntExist($path2));
    }

    public function testDoesntExist()
    {
        $this->assertTrue($this->directory()->doesntExist(__DIR__ . '/../../../Foo'));
        $this->assertTrue($this->directory()->doesntExist(__DIR__ . '/../../../Instances/Foo.php'));
    }

    public function testNames()
    {
        $available = ['Concerns', 'Contracts', 'Exceptions', 'Facades', 'Foo', 'Instances', 'stubs'];

        $names = $this->directory()->names($this->fixturesDirectory());

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

        $names = $this->directory()->names($this->fixturesDirectory(), null, true);

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

        $this->directory()->validate($this->fixturesDirectory('qwe/rty'));
    }

    public function testValidatedSuccess()
    {
        $path = $this->fixturesDirectory();

        $result = $this->directory()->validated($path);

        $this->assertSame(realpath($path), $result);
    }

    public function testValidatedFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        $this->directory()->validated($this->fixturesDirectory('qwe/rty'));
    }

    protected function directory(): Directory
    {
        return new Directory();
    }
}
