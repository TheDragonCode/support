<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
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
    public function testDelete()
    {
        $path = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path);

        $this->assertTrue(Directory::make($path, 777));

        $this->assertDirectoryExists($path);

        $this->assertTrue(Directory::delete($path));

        $this->assertFalse(Directory::exists($path));
    }

    public function testDeleteDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "qwe" does not exist.');

        $this->assertTrue(Directory::delete('qwe'));
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
