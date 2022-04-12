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

namespace Tests\Unit\Filesystem\Path;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Instances\Instance;
use Tests\TestCase;

class BasenameTest extends TestCase
{
    public function testBasename()
    {
        $this->assertSame('rty.jpg', Path::basename('/foo/bar/qwe/rty.jpg'));

        $this->assertSame(Instance::basename(static::class) . '.php', Path::basename(__FILE__));
    }
}
