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

use DragonCode\Support\Facades\Filesystem\Directory;
use Tests\TestCase;

class EnsureDeleteTest extends TestCase
{
    public function testOne()
    {
        $path = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path);

        Directory::make($path);

        $this->assertDirectoryExists($path);

        Directory::ensureDelete($path);

        $this->assertDirectoryDoesNotExist($path);
    }

    public function testMany()
    {
        $path1 = $this->tempDirectory();
        $path2 = 'foo';

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);

        Directory::make($path1);

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryDoesNotExist($path2);

        Directory::ensureDelete([$path1, $path2]);

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);
    }
}
