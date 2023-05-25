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

namespace Tests\Unit\Filesystem\File;

use DirectoryIterator;
use DragonCode\Support\Facades\Filesystem\File;
use SplFileInfo;
use Tests\TestCase;

class IsFileTest extends TestCase
{
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
}
