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

use ArrayObject;
use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class CountTest extends TestCase
{
    public function testCount()
    {
        $this->assertSame(0, Arr::count([]));
        $this->assertSame(1, Arr::count(['foo' => 'bar']));
        $this->assertSame(2, Arr::count(['foo' => 'bar', 'bar' => 'baq']));

        $this->assertSame(1, Arr::count(['foo']));
        $this->assertSame(2, Arr::count(['foo', 'bar']));
        $this->assertSame(3, Arr::count(['foo', 'bar', 'baq']));
    }

    public function testObject()
    {
        $this->assertSame(0, Arr::count(new ArrayObject([])));
        $this->assertSame(1, Arr::count(new ArrayObject(['foo' => 'bar'])));
        $this->assertSame(2, Arr::count(new ArrayObject(['foo' => 'bar', 'bar' => 'baq'])));

        $this->assertSame(1, Arr::count(new ArrayObject(['foo'])));
        $this->assertSame(2, Arr::count(new ArrayObject(['foo', 'bar'])));
        $this->assertSame(3, Arr::count(new ArrayObject(['foo', 'bar', 'baq'])));
    }
}
