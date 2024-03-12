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

class CombineTest extends TestCase
{
    public function testCombine()
    {
        $arr1 = [
            'Bar',
            'Foo',
            'Bar',
            'Baz',
            ['foo' => 'Foo', 'bar' => 'Bar'],
            'Qwerty',
        ];

        $arr2 = [
            'Bar bar',
            'Foo bar',
            ['baz' => 'AAA'],
            ['aaa' => 'BBB'],
            ['bbb' => 'CCC'],
        ];

        $expected = [
            'Bar',
            'Foo',
            'Bar',
            'Baz',
            ['Foo', 'Bar'],
            'Qwerty',
            'Bar bar',
            'Foo bar',
            ['AAA'],
            ['BBB'],
            ['CCC'],
        ];

        $result = Arr::combine($arr1, $arr2);

        $this->assertSame($expected, $result);
    }

    public function testCombineWithArrayKeys()
    {
        $arr1 = [
            'a' => 'Bar',
            'b' => 'Foo',
            'c' => 'Bar',
            'd' => 'Baz',
            'e' => ['foo' => 'Foo', 'bar' => 'Bar'],
            'f' => 'Qwerty',
        ];

        $arr2 = [
            'g' => 'Bar bar',
            'h' => 'Foo bar',
            'i' => ['baz' => 'Baz'],
            'j' => ['aaa' => 'AAA'],
            'k' => ['bbb' => 'BBB'],
        ];

        $expected = [
            'Bar',
            'Foo',
            'Bar',
            'Baz',
            'e' => ['Foo', 'Bar'],
            'Qwerty',
            'Bar bar',
            'Foo bar',
            'i' => ['Baz'],
            'j' => ['AAA'],
            'k' => ['BBB'],
        ];

        $result = Arr::combine($arr1, $arr2);

        $this->assertSame($expected, $result);
    }
}
