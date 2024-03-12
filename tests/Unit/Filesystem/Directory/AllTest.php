<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Filesystem\Directory;

use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Facades\Filesystem\Directory;
use Tests\TestCase;

class AllTest extends TestCase
{
    public function testAll()
    {
        $available = ['.', '..', 'Concerns', 'Contracts', 'Exceptions', 'Facades', 'Foo', 'Instances', 'stubs'];

        $dirs = Directory::all($this->fixturesDirectory());

        foreach ($dirs as $dir) {
            in_array($dir->getFilename(), $available)
                ? $this->assertTrue(Directory::isDirectory($dir), 'Path is ' . $dir->getRealPath())
                : $this->assertFalse(Directory::isDirectory($dir), 'Path is ' . $dir->getRealPath());
        }
    }

    public function testAllDoesntExists()
    {
        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "qwerty" does not exist.');

        Directory::all('qwerty');
    }

    public function testAsFile()
    {
        $path = realpath($this->fixturesDirectory('.gitkeep'));

        $this->expectException(DirectoryNotFoundException::class);
        $this->expectExceptionMessage('Directory "' . $path . '" does not exist.');

        Directory::all($path);
    }
}
