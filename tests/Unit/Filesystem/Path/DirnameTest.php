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

namespace Tests\Unit\Filesystem\Path;

use DragonCode\Support\Facades\Filesystem\Path;
use Tests\TestCase;

class DirnameTest extends TestCase
{
    public function testDirname()
    {
        $this->assertSame('/foo/bar/qwe', Path::dirname('/foo/bar/qwe/rty.jpg'));

        $this->assertSame(__DIR__, Path::dirname(__FILE__));
    }
}
