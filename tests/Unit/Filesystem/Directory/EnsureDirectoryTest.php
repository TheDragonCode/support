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

use DragonCode\Support\Facades\Filesystem\Directory;
use Tests\TestCase;

class EnsureDirectoryTest extends TestCase
{
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

        Directory::ensureDirectory($path, 0o755, true);

        $this->assertTrue(Directory::exists($path));
        $this->assertTrue(Directory::doesntExist($path1));
        $this->assertTrue(Directory::doesntExist($path2));
    }
}
