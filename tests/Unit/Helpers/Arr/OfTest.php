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
use DragonCode\Support\Helpers\Ables\Arrayable;
use DragonCode\Support\Helpers\Arr as ArrHelper;
use Tests\TestCase;
use TypeError;

class OfTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame([], Arr::of()->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of());

        $this->assertSame([], Arr::of(null)->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of(null));

        $this->assertSame([], Arr::of([])->toArray());
        $this->assertInstanceOf(Arrayable::class, Arr::of([]));
    }

    public function testGet()
    {
        $source = ['foo' => 'Foo'];

        $this->assertSame('Foo', Arr::of($source)->get('foo'));
        $this->assertNull(Arr::of($source)->get('bar'));

        $this->assertSame('bar', Arr::of($source)->get('qwe', 'bar'));
        $this->assertSame('bar', Arr::of($source)->get('qwe', fn () => 'bar'));
    }

    public function testStringGiven()
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(ArrHelper::class . '::of(): Argument #1 ($value) must be of type ArrayObject|array|null, string given');

        $this->assertSame([], Arr::of('')->toArray());
    }
}
