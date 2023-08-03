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
use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function testOne()
    {
        $path = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path);

        $this->assertTrue(Directory::make($path, 777));

        $this->assertDirectoryExists($path);

        Directory::delete($path);

        $this->assertFalse(Directory::exists($path));
    }

    public function testMany()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);

        Directory::make($path1);
        Directory::make($path2);

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryExists($path2);

        Directory::delete([$path1, $path2]);

        $this->assertFalse(Directory::exists($path1));
        $this->assertFalse(Directory::exists($path2));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "qwe" does not exist.');

        Directory::delete('qwe');
    }

    public function testDeleteAsFile()
    {
        $path = $this->tempDirectory('.gitkeep');

        File::store($path, 'foo', 777);

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        Directory::delete($path);
    }
}
