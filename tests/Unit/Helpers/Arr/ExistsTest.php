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

class ExistsTest extends TestCase
{
    public function testExists()
    {
        $this->assertTrue(Arr::exists(['foo' => 'bar'], 'foo'));
        $this->assertFalse(Arr::exists(['foo' => 'bar'], 'bar'));

        $this->assertTrue(Arr::exists(new Arrayable(), 'foo'));
        $this->assertTrue(Arr::exists(new Arrayable(), 'bar'));
        $this->assertFalse(Arr::exists(new Arrayable(), 'qwe'));
        $this->assertFalse(Arr::exists(new Arrayable(), 'rty'));

        $this->assertTrue(Arr::exists(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.baz'));
        $this->assertFalse(Arr::exists(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.qwerty'));
    }
}
