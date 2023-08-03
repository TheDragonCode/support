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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Instances\Arrayable;
use Tests\TestCase;

class ExistsWithoutDotTest extends TestCase
{
    public function testExistsWithoutDot()
    {
        $this->assertTrue(Arr::existsWithoutDot(['foo' => 'bar'], 'foo'));
        $this->assertFalse(Arr::existsWithoutDot(['foo' => 'bar'], 'bar'));

        $this->assertTrue(Arr::existsWithoutDot(new Arrayable(), 'foo'));
        $this->assertTrue(Arr::existsWithoutDot(new Arrayable(), 'bar'));
        $this->assertFalse(Arr::existsWithoutDot(new Arrayable(), 'qwe'));
        $this->assertFalse(Arr::existsWithoutDot(new Arrayable(), 'rty'));

        $this->assertFalse(Arr::existsWithoutDot(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.baz'));
        $this->assertFalse(Arr::existsWithoutDot(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.qwerty'));
    }
}
