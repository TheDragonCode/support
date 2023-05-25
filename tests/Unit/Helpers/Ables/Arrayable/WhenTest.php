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

namespace Tests\Unit\Helpers\Ables\Arrayable;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Arrayable;
use Tests\TestCase;

class WhenTest extends TestCase
{
    public function testTrue()
    {
        $object = Arr::of(['foo', 'bar'])->when(
            true,
            fn (Arrayable $able) => $able->map(fn ($value) => Str::upper($value))
        );

        $this->assertInstanceOf(Arrayable::class, $object);
        $this->assertSame(['FOO', 'BAR'], $object->toArray());
    }

    public function testFalse()
    {
        $object = Arr::of(['foo', 'bar'])->when(
            false,
            fn (Arrayable $able) => $able->map(fn ($value) => Str::upper($value))
        );

        $this->assertInstanceOf(Arrayable::class, $object);
        $this->assertSame(['foo', 'bar'], $object->toArray());
    }
}
