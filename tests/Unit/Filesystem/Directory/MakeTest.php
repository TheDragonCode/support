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

class MakeTest extends TestCase
{
    public function testMake()
    {
        $path = $this->tempDirectory();

        $this->assertFalse(Directory::exists($path));

        $this->assertTrue(Directory::make($path, 777));

        $this->assertDirectoryExists($path);
    }
}
