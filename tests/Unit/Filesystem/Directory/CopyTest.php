<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Filesystem\Directory;

use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Exceptions\InvalidDestinationPathException;
use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use Tests\TestCase;

class CopyTest extends TestCase
{
    public function testEmpty()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        Directory::ensureDirectory($path1);

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryDoesNotExist($path2);

        Directory::copy($path1, $path2);

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryExists($path2);
    }

    public function testWithFiles()
    {
        $path1 = $this->fixturesDirectory('Foo');
        $path2 = $this->tempDirectory();

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryDoesNotExist($path2);

        $this->assertFileExists($path1 . '/Bar/.gitkeep');
        $this->assertFileDoesNotExist($path2 . '/Bar/.gitkeep');

        Directory::copy($path1, $path2);

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryExists($path2);

        $this->assertFileExists($path1 . '/Bar/.gitkeep');
        $this->assertFileExists($path2 . '/Bar/.gitkeep');
    }

    public function testExistTarget()
    {
        $path1 = $this->fixturesDirectory('Foo');
        $path2 = $this->tempDirectory();

        File::store($path2 . '/Custom/.gitkeep', '');

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryExists($path2);

        $this->assertFileExists($path1 . '/Bar/.gitkeep');
        $this->assertFileDoesNotExist($path2 . '/Bar/.gitkeep');
        $this->assertFileExists($path2 . '/Custom/.gitkeep');

        Directory::copy($path1, $path2);

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryExists($path2);

        $this->assertFileExists($path1 . '/Bar/.gitkeep');
        $this->assertFileExists($path2 . '/Bar/.gitkeep');
        $this->assertFileExists($path2 . '/Custom/.gitkeep');
    }

    public function testIncorrectSource()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage("Directory \"$path1\" does not exist.");

        Directory::copy($path1, $path2);
    }

    public function testYourself()
    {
        $path = $this->fixturesDirectory();

        $this->expectException(InvalidDestinationPathException::class);
        $this->expectExceptionMessage('The start and end paths must not be the same: ' . realpath($path));

        Directory::copy($path, $path);
    }

    public function testDoesntExist()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage("Directory \"$path1\" does not exist.");

        Directory::copy($path1, $path2);
    }
}
