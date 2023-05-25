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

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Instances\Call;
use Tests\TestCase;

class CallbackTest extends TestCase
{
    public function testCallback()
    {
        $this->assertSame('foo', Call::callback(fn () => 'foo'));
        $this->assertSame('FOO', Call::callback(fn ($value) => Str::upper($value), 'foo'));

        $this->assertNull(Call::callback('foo'));
        $this->assertNull(Call::callback('123'));
        $this->assertNull(Call::callback(123));
    }
}
