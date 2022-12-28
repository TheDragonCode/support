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
use Tests\TestCase;

class FlattenKeysTest extends TestCase
{
    public function testFlattenKeys()
    {
        $array = ['foo', 'bar', 'baz'];
        $this->assertEquals($array, Arr::flattenKeys($array));

        $array = ['f' => ['foo', 'bar', 'baz'], 'b' => ['q', 'w', 'e']];
        $this->assertEquals([
            'f.0' => 'foo',
            'f.1' => 'bar',
            'f.2' => 'baz',
            'b.0' => 'q',
            'b.1' => 'w',
            'b.2' => 'e',
        ], Arr::flattenKeys($array));

        $array = [
            'f' => ['q' => 'Q', 'w' => 'W', 'e' => 'E'],
            'b' => ['a' => 'A', 's' => 'S', 'd' => 'D'],
        ];
        $this->assertEquals([
            'f.q' => 'Q',
            'f.w' => 'W',
            'f.e' => 'E',
            'b.a' => 'A',
            'b.s' => 'S',
            'b.d' => 'D',
        ], Arr::flattenKeys($array));
    }

    public function testFlattenKeysCustomDelimiter()
    {
        $array = ['foo', 'bar', 'baz'];
        $this->assertEquals($array, Arr::flattenKeys($array, '_'));

        $array = ['f' => ['foo', 'bar', 'baz'], 'b' => ['q', 'w', 'e']];
        $this->assertEquals([
            'f_0' => 'foo',
            'f_1' => 'bar',
            'f_2' => 'baz',
            'b_0' => 'q',
            'b_1' => 'w',
            'b_2' => 'e',
        ], Arr::flattenKeys($array, '_'));

        $array = [
            'f' => ['q' => 'Q', 'w' => 'W', 'e' => 'E'],
            'b' => ['a' => 'A', 's' => 'S', 'd' => 'D'],
        ];
        $this->assertEquals([
            'f_q' => 'Q',
            'f_w' => 'W',
            'f_e' => 'E',
            'b_a' => 'A',
            'b_s' => 'S',
            'b_d' => 'D',
        ], Arr::flattenKeys($array, '_'));
    }

    public function testNested()
    {
        $array = [
            'accepted'    => 'The :attribute must be accepted.',
            'accepted_if' => 'The :attribute must be accepted when :other is :value.',
            'active_url'  => 'The :attribute is not a valid URL.',

            'between'     => [
                'numeric' => 'The :attribute must be between :min and :max.',
                'file'    => 'The :attribute must be between :min and :max kilobytes.',
                'string'  => 'The :attribute must be between :min and :max characters.',
                'array'   => 'The :attribute must have between :min and :max items.',
                'foo'     => [
                    'bar' => 'Bar',
                    'baq' => 'Baq',
                ],
            ],

            'custom'      => [
                'attribute-name' => [
                    'rule-name' => 'custom-message',
                ],
            ],

            'attributes'  => [],
        ];

        $expected = [
            'accepted'                        => 'The :attribute must be accepted.',
            'accepted_if'                     => 'The :attribute must be accepted when :other is :value.',
            'active_url'                      => 'The :attribute is not a valid URL.',

            'between.numeric'                 => 'The :attribute must be between :min and :max.',
            'between.file'                    => 'The :attribute must be between :min and :max kilobytes.',
            'between.string'                  => 'The :attribute must be between :min and :max characters.',
            'between.array'                   => 'The :attribute must have between :min and :max items.',
            'between.foo.bar'                 => 'Bar',
            'between.foo.baq'                 => 'Baq',

            'custom.attribute-name.rule-name' => 'custom-message',
        ];

        $this->assertEquals($expected, Arr::flattenKeys($array));
    }
}
