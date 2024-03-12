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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class GetKeyTest extends TestCase
{
    public function testGetKeyIfExist()
    {
        $this->assertEquals('foo', Arr::getKey(['foo' => 'bar'], 'foo'));
        $this->assertEquals('foo', Arr::getKey(['foo' => 'bar'], 'foo', 'bar'));
        $this->assertEquals('baz', Arr::getKey(['foo' => 'bar'], 'bar', 'baz'));

        $this->assertNull(Arr::get(['foo' => 'bar'], 'bar'));
    }
}
