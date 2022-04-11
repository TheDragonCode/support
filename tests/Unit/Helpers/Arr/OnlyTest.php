<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
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

class OnlyTest extends TestCase
{
    public function testOnly()
    {
        $arr = [
            'foo'    => 'Foo',
            'bar'    => 'Bar',
            'baz'    => 'Baz',
            'qwerty' => [
                'q' => 'Q',
                'w' => 'W',
                'e' => 'E',
            ],
            200      => 'Num 200',
            400      => 'Num 400',
            500      => [
                'r' => 'R',
                't' => 'T',
                'y' => 'Y',
            ],
        ];

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], Arr::only($arr, ['foo', 'bar']));
        $this->assertSame(['bar' => 'Bar', 200 => 'Num 200'], Arr::only($arr, ['bar', 200]));

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 'qwerty' => ['q' => 'Q', 'w' => 'W', 'e' => 'E']],
            Arr::only($arr, ['foo', 'baz', 'qwerty'])
        );

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            Arr::only($arr, ['foo', 'baz', 500])
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            Arr::only($arr, ['foo', 'qwerty' => ['w'], 500])
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['t' => 'T', 'y' => 'Y']],
            Arr::only($arr, ['foo', 'qwerty' => ['w'], 500 => ['t', 'y']])
        );

        $this->assertSame([], Arr::only($arr, []));
        $this->assertSame([], Arr::only($arr, null));
    }

    public function testOnlyDiffKeys()
    {
        $arr = [
            'foo'    => 'Foo',
            'bar'    => 'Bar',
            'baz'    => 'Baz',
            'qwerty' => [
                'q' => 'Q',
                'w' => 'W',
                'e' => 'E',
            ],
            200      => 'Num 200',
            400      => 'Num 400',
            500      => [
                'r' => 'R',
                't' => 'T',
                'y' => 'Y',
            ],
        ];

        $this->assertSame(
            [
                'foo'    => 'Foo',
                'bar'    => 'Bar',
                'qwerty' => [
                    'q' => 'Q',
                    'e' => 'E',
                ],
            ],
            Arr::only($arr, [
                'foo',
                'bar',
                'qwerty'        => ['q', 'e'],
                'unknown_key',
                'unknown_array' => ['foo', 'bar'],
            ])
        );
    }

    public function testOnlyCallback()
    {
        $arr = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], Arr::only($arr, static fn ($key): bool => Str::startsWith($key, ['foo', 'bar'])));

        $this->assertSame(['bar' => 'Bar', 'baz' => 'Baz'], Arr::only($arr, static fn ($key): bool => Str::startsWith($key, 'ba')));

        $this->assertSame([200 => 'Num 200', 400 => 'Num 400'], Arr::only($arr, static fn ($key): bool => is_numeric($key)));
    }
}
