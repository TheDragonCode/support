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

class EnsureDeleteTest extends TestCase
{
    public function testEnsureDelete()
    {
        $path1 = $this->tempDirectory();
        $path2 = $this->tempDirectory();

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);

        $this->assertTrue(Directory::make($path1, 777));

        $this->assertDirectoryExists($path1);
        $this->assertDirectoryDoesNotExist($path2);

        $this->assertTrue(Directory::ensureDelete($path1));
        $this->assertTrue(Directory::ensureDelete($path2));

        $this->assertDirectoryDoesNotExist($path1);
        $this->assertDirectoryDoesNotExist($path2);
    }
}
