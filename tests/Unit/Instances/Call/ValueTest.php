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

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Instances\Call;
use Tests\TestCase;

class ValueTest extends TestCase
{
    public function testValue()
    {
        $this->assertSame('foo', Call::value('foo'));
        $this->assertSame('foo', Call::value(fn () => 'foo'));
        $this->assertSame('foo', Call::value(fn ($val) => $val, 'foo'));
        $this->assertSame('foo', Call::value(fn ($val) => $val, ['foo']));
    }
}
