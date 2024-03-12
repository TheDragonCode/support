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
use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class ExceptTest extends TestCase
{
    public function testExcept()
    {
        $array = [
            'foo' => 123,
            'bar' => 456,
            'baz' => 789,
        ];

        $this->assertSame(['bar' => 456, 'baz' => 789], Arr::except($array, 'foo'));
        $this->assertSame(['bar' => 456, 'baz' => 789], Arr::except($array, ['foo']));

        $this->assertSame(['bar' => 456], Arr::except($array, ['foo', 'baz']));

        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], Arr::except($array, []));
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], Arr::except($array, null));
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], Arr::except($array, 123));

        $this->assertSame([], Arr::except([], []));
        $this->assertSame([], Arr::except([], ''));
        $this->assertSame([], Arr::except([], ['foo', 'bar']));
    }

    public function testExceptCallback()
    {
        $arr = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $this->assertSame(['baz' => 'Baz', 200 => 'Num 200', 400 => 'Num 400'], Arr::except($arr, static fn ($key): bool => ! Str::startsWith($key, ['foo', 'bar'])));

        $this->assertSame(['foo' => 'Foo', 200 => 'Num 200', 400 => 'Num 400'], Arr::except($arr, static fn ($key): bool => ! Str::startsWith($key, 'ba')));

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'], Arr::except($arr, static fn ($key): bool => ! is_numeric($key)));
    }
}
