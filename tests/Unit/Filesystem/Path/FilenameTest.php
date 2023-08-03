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
use DragonCode\Support\Facades\Instances\Instance;
use Tests\TestCase;

class FilenameTest extends TestCase
{
    public function testFilename()
    {
        $this->assertSame('rty', Path::filename('/foo/bar/qwe/rty.jpg'));

        $this->assertSame(Instance::basename(static::class), Path::filename(__FILE__));
    }
}
