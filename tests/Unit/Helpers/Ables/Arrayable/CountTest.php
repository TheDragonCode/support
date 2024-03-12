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

namespace Tests\Unit\Helpers\Ables\Arrayable;

use ArrayObject;
use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class CountTest extends TestCase
{
    public function testCount()
    {
        $this->assertSame(0, Arr::of([])->count());
        $this->assertSame(1, Arr::of(['foo' => 'bar'])->count());
        $this->assertSame(2, Arr::of(['foo' => 'bar', 'bar' => 'baq'])->count());

        $this->assertSame(1, Arr::of(['foo'])->count());
        $this->assertSame(2, Arr::of(['foo', 'bar'])->count());
        $this->assertSame(3, Arr::of(['foo', 'bar', 'baq'])->count());
    }

    public function testObject()
    {
        $this->assertSame(0, Arr::of(new ArrayObject([]))->count());
        $this->assertSame(1, Arr::of(new ArrayObject(['foo' => 'bar']))->count());
        $this->assertSame(2, Arr::of(new ArrayObject(['foo' => 'bar', 'bar' => 'baq']))->count());

        $this->assertSame(1, Arr::of(new ArrayObject(['foo']))->count());
        $this->assertSame(2, Arr::of(new ArrayObject(['foo', 'bar']))->count());
        $this->assertSame(3, Arr::of(new ArrayObject(['foo', 'bar', 'baq']))->count());
    }
}
