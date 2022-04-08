<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Instances\Helpers\Ables;

use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Arrayable;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ArrayableTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame([], $this->arr()->toArray());
        $this->assertInstanceOf(Arrayable::class, $this->arr());

        $this->assertSame([], $this->arr(null)->toArray());
        $this->assertInstanceOf(Arrayable::class, $this->arr(null));

        $this->assertSame([], $this->arr([])->toArray());
        $this->assertInstanceOf(Arrayable::class, $this->arr([]));

        $this->assertSame([], $this->arr('')->toArray());
        $this->assertInstanceOf(Arrayable::class, $this->arr(''));
    }

    public function testGet()
    {
        $obj = new Foo();

        $this->assertSame(['foo' => 'bar'], $this->arr(['foo' => 'bar'])->toArray());
        $this->assertSame(compact('obj'), $this->arr(compact('obj'))->toArray());
    }

    public function testExcept()
    {
        $array = [
            'foo' => 123,
            'bar' => 456,
            'baz' => 789,
        ];

        $this->assertSame(['bar' => 456, 'baz' => 789], $this->arr($array)->except('foo')->toArray());
        $this->assertSame(['bar' => 456, 'baz' => 789], $this->arr($array)->except(['foo'])->toArray());

        $this->assertSame(['bar' => 456], $this->arr($array)->except(['foo', 'baz'])->toArray());

        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], $this->arr($array)->except([])->toArray());
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], $this->arr($array)->except(null)->toArray());
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], $this->arr($array)->except(123)->toArray());

        $this->assertSame([], $this->arr([])->except([])->toArray());
        $this->assertSame([], $this->arr([])->except('')->toArray());
        $this->assertSame([], $this->arr([])->except(['foo', 'bar'])->toArray());
    }

    public function testExceptCallback()
    {
        $array = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $this->assertSame(
            ['baz' => 'Baz', 200 => 'Num 200', 400 => 'Num 400'],
            $this->arr($array)->except(
                static fn ($key): bool => ! Str::startsWith($key, ['foo', 'bar'])
            )->toArray()
        );

        $this->assertSame(
            ['foo' => 'Foo', 200 => 'Num 200', 400 => 'Num 400'],
            $this->arr($array)->except(
                static fn ($key): bool => ! Str::startsWith($key, 'ba')
            )->toArray()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'],
            $this->arr($array)->except(
                static fn ($key): bool => ! is_numeric($key)
            )->toArray()
        );
    }

    public function testRenameKeys()
    {
        $source = [
            'foo' => 123,
            'BaR' => 456,
            'BAZ' => 789,
        ];

        $expected_renamed = [
            'FOO' => 123,
            'BAR' => 456,
            'BAZ' => 789,
        ];

        $expected_modified = [
            'foo_123' => 123,
            'bar_456' => 456,
            'baz_789' => 789,
        ];

        $renamed = $this->arr($source)->renameKeys(static fn ($key): string => mb_strtoupper($key))->toArray();

        $modified = $this->arr($source)->renameKeys(static fn ($key, $value): string => mb_strtolower($key) . '_' . $value)->toArray();

        $this->assertSame($expected_renamed, $renamed);
        $this->assertSame($expected_modified, $modified);
    }

    public function testRenameKeysMap()
    {
        $source = [
            'foo' => 123,
            'BaR' => 456,
            'BAZ' => 789,
        ];

        $expected = [
            'FOOX' => 123,
            'BARX' => 456,
            'BAZ'  => 789,
        ];

        $map = [
            'foo' => 'FOOX',
            'BaR' => 'BARX',
        ];

        $renamed = $this->arr($source)->renameKeysMap($map)->toArray();

        $this->assertSame($expected, $renamed);
    }

    public function testMerge()
    {
        $arr1 = [
            'foo' => 'Bar',
            '0'   => 'Foo',
            '2'   => 'Bar',
            '400' => 'Baz',
            600   => ['foo' => 'Foo', 'bar' => 'Bar'],
        ];

        $arr2 = [
            '2'   => 'Bar bar',
            '500' => 'Foo bar',
            '600' => ['baz' => 'Baz'],
            '700' => ['aaa' => 'AAA'],
        ];

        $expected = [
            'foo' => 'Bar',
            0     => 'Foo',
            2     => 'Bar bar',
            400   => 'Baz',
            600   => ['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'],
            500   => 'Foo bar',
            700   => ['aaa' => 'AAA'],
        ];

        $result1 = $this->arr($arr1)->merge($arr2)->toArray();
        $result2 = $this->arr($arr1)->merge($arr1, $arr2)->toArray();
        $result3 = $this->arr()->merge($arr1, $arr2)->toArray();

        $this->assertSame($expected, $result1);
        $this->assertSame($expected, $result2);
        $this->assertSame($expected, $result3);
    }

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

        $result = $this->arr($arr1)->combine($arr2)->toArray();

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

        $result = $this->arr($arr1)->combine($arr2)->toArray();

        $this->assertSame($expected, $result);
    }

    public function testOnly()
    {
        $array = [
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

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr($array)->only(['foo', 'bar'])->toArray());
        $this->assertSame(['bar' => 'Bar', 200 => 'Num 200'], $this->arr($array)->only(['bar', 200])->toArray());

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 'qwerty' => ['q' => 'Q', 'w' => 'W', 'e' => 'E']],
            $this->arr($array)->only(['foo', 'baz', 'qwerty'])->toArray()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            $this->arr($array)->only(['foo', 'baz', 500])->toArray()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            $this->arr($array)->only(['foo', 'qwerty' => ['w'], 500])->toArray()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['t' => 'T', 'y' => 'Y']],
            $this->arr($array)->only(['foo', 'qwerty' => ['w'], 500 => ['t', 'y']])->toArray()
        );

        $this->assertSame([], $this->arr($array)->only([])->toArray());
        $this->assertSame([], $this->arr($array)->only(null)->toArray());
    }

    public function testOnlyCallback()
    {
        $array = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr($array)->only(static fn ($key): bool => Str::startsWith($key, ['foo', 'bar']))->toArray());

        $this->assertSame(['bar' => 'Bar', 'baz' => 'Baz'], $this->arr($array)->only(static fn ($key): bool => Str::startsWith($key, 'ba'))->toArray());

        $this->assertSame([200 => 'Num 200', 400 => 'Num 400'], $this->arr($array)->only(static fn ($key): bool => is_numeric($key))->toArray());
    }

    public function testFilter()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $target = [
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
        ];

        $result = $this->arr($source)->filter(
            static fn ($value, $key): bool => Str::contains($value, 200) || Str::startsWith($key, 'b'),
            ARRAY_FILTER_USE_BOTH
        )->toArray();

        $this->assertSame($target, $result);
    }

    public function testFilterEmpty()
    {
        $source = [
            'Foo',
            null,
            'Bar',
            '',
            0,
            0.0,
            true,
            false,
        ];

        $expected = [
            0 => 'Foo',
            2 => 'Bar',
            6 => true,
            7 => false,
        ];

        $result = $this->arr($source)->filter()->toArray();

        $this->assertSame($expected, $result);
    }

    public function testFlatten()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->toArray());

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->toArray());

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', null, '#baz', null], $this->arr($array)->flatten()->toArray());

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->toArray());

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->toArray());
    }

    public function testFlattenDoesntIgnore()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten(false)->toArray());

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#baz'], $this->arr($array)->flatten(false)->toArray());

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', '#baz', null], $this->arr($array)->flatten(false)->toArray());

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten(false)->toArray());

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten(false)->toArray());
    }

    public function testSortByKeys()
    {
        $source = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];

        $sorter = ['q', 'w', 'e'];

        $expected = ['q' => 1, 'w' => 123, 'r' => 2, 's' => 5];

        $actual = $this->arr($source)->sortByKeys($sorter)->toArray();

        $this->assertSame($expected, $actual);
    }

    public function testSort()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            700 => 700,

            '*' => '*',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            400 => 400,

            'all_key' => 'All_Key',
            'add_key' => 'Add_Key',

            0   => 0,
            '_' => '_',
            '-' => '-',

            'sub' => [
                'add key' => 'Add key',
                'all key' => 'All key',

                700 => 700,

                '*' => '*',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                400 => 400,

                'all_key' => 'All_Key',
                'add_key' => 'Add_Key',

                0   => 0,
                '_' => '_',
                '-' => '-',

                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'allkey' => 'AllKey',
                'addkey' => 'AddKey',
            ],

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'allkey' => 'AllKey',
            'addkey' => 'AddKey',
        ];

        $target = [
            '*',
            '-',
            '_',

            0,
            1,
            2,
            5,
            123,
            400,
            700,

            'Add key',
            'Add_Key',
            'AddKey',
            'All key',
            'All_Key',
            'AllKey',
            'API key',
            'Are you sure',

            [
                '*',
                '-',
                '_',

                0,
                1,
                2,
                5,
                123,
                400,
                700,

                'Add key',
                'Add_Key',
                'AddKey',
                'All key',
                'All_Key',
                'AllKey',
                'API key',
                'Are you sure',
            ],
        ];

        $this->assertSame($target, $this->arr($source)->sort()->toArray());
    }

    public function testSortCallback()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            700 => 700,

            '*' => '*',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            '-' => '-',

            400 => 400,

            'all_key' => 'All_Key',
            'add_key' => 'Add_Key',

            0   => 0,
            '_' => '_',

            'sub' => [
                'add key' => 'Add key',
                'all key' => 'All key',

                700 => 700,

                '*' => '*',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                '-' => '-',

                400 => 400,

                'all_key' => 'All_Key',
                'add_key' => 'Add_Key',

                0   => 0,
                '_' => '_',

                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'allkey' => 'AllKey',
                'addkey' => 'AddKey',
            ],

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'allkey' => 'AllKey',
            'addkey' => 'AddKey',
        ];

        $target = [
            '*',
            '-',
            '_',

            'Add key',
            'Add_Key',
            'AddKey',
            'All key',
            'All_Key',
            'AllKey',
            'API key',
            'Are you sure',

            0,
            1,
            2,
            5,
            123,
            400,
            700,

            [
                '*',
                '-',
                '_',

                'Add key',
                'Add_Key',
                'AddKey',
                'All key',
                'All_Key',
                'AllKey',
                'API key',
                'Are you sure',

                0,
                1,
                2,
                5,
                123,
                400,
                700,
            ],
        ];

        $callback = static function ($current, $next) {
            $current = is_string($current) ? Str::lower($current) : $current;
            $next    = is_string($next) ? Str::lower($next) : $next;

            if ($current === $next) {
                return 0;
            }

            if (is_string($current) && is_numeric($next)) {
                return -1;
            }

            if (is_numeric($current) && is_string($next)) {
                return 1;
            }

            return $current < $next ? -1 : 1;
        };

        $this->assertSame($target, $this->arr($source)->sort($callback)->toArray());
    }

    public function testKsort()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            700 => 'Number 700',

            '*' => 'asterisk',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            '-' => 'hyphen',

            400 => 'Number 400',

            'all_key' => 'All_Key',
            'add_key' => 'Add_Key',

            0   => 'Number 0',
            '_' => 'underscore',

            'sub' => [
                'add key' => 'Add key',
                'all key' => 'All key',

                700 => 'Number 700',

                '*' => 'asterisk',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                '-' => 'hyphen',

                400 => 'Number 400',

                'all_key' => 'All_Key',
                'add_key' => 'Add_Key',

                0   => 'Number 0',
                '_' => 'underscore',

                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'allkey' => 'AllKey',
                'addkey' => 'AddKey',
            ],

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'allkey' => 'AllKey',
            'addkey' => 'AddKey',
        ];

        $target = [
            '*' => 'asterisk',
            '-' => 'hyphen',

            '_' => 'underscore',

            0   => 'Number 0',
            400 => 'Number 400',
            700 => 'Number 700',

            'add key'      => 'Add key',
            'add_key'      => 'Add_Key',
            'addkey'       => 'AddKey',
            'all key'      => 'All key',
            'all_key'      => 'All_Key',
            'allkey'       => 'AllKey',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,

            'sub' => [
                '*' => 'asterisk',
                '-' => 'hyphen',

                '_' => 'underscore',

                0   => 'Number 0',
                400 => 'Number 400',
                700 => 'Number 700',

                'add key'      => 'Add key',
                'add_key'      => 'Add_Key',
                'addkey'       => 'AddKey',
                'all key'      => 'All key',
                'all_key'      => 'All_Key',
                'allkey'       => 'AllKey',
                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,
            ],

            'w' => 123,
        ];

        $this->assertSame($target, $this->arr($source)->ksort()->toArray());
    }

    public function testKsortCallback()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            700 => 'Number 700',

            '*' => 'asterisk',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            '-' => 'hyphen',

            400 => 'Number 400',

            'all_key' => 'All_Key',
            'add_key' => 'Add_Key',

            0   => 'Number 0',
            '_' => 'underscore',

            'sub' => [
                'add key' => 'Add key',
                'all key' => 'All key',

                700 => 'Number 700',

                '*' => 'asterisk',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                '-' => 'hyphen',

                400 => 'Number 400',

                'all_key' => 'All_Key',
                'add_key' => 'Add_Key',

                0   => 'Number 0',
                '_' => 'underscore',

                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'allkey' => 'AllKey',
                'addkey' => 'AddKey',
            ],

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'allkey' => 'AllKey',
            'addkey' => 'AddKey',
        ];

        $target = [
            '*' => 'asterisk',
            '-' => 'hyphen',

            '_' => 'underscore',

            'add key'      => 'Add key',
            'add_key'      => 'Add_Key',
            'addkey'       => 'AddKey',
            'all key'      => 'All key',
            'all_key'      => 'All_Key',
            'allkey'       => 'AllKey',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,

            'sub' => [
                '*' => 'asterisk',
                '-' => 'hyphen',

                '_' => 'underscore',

                'add key'      => 'Add key',
                'add_key'      => 'Add_Key',
                'addkey'       => 'AddKey',
                'all key'      => 'All key',
                'all_key'      => 'All_Key',
                'allkey'       => 'AllKey',
                'API key'      => 'API key',
                'Are you sure' => 'Are you sure',

                'q' => 1,
                'r' => 2,
                's' => 5,
                'w' => 123,

                0   => 'Number 0',
                400 => 'Number 400',
                700 => 'Number 700',
            ],

            'w' => 123,

            0   => 'Number 0',
            400 => 'Number 400',
            700 => 'Number 700',
        ];

        $callback = static function ($current, $next) {
            $current = is_string($current) ? Str::lower($current) : $current;
            $next    = is_string($next) ? Str::lower($next) : $next;

            if ($current === $next) {
                return 0;
            }

            if (is_string($current) && is_numeric($next)) {
                return -1;
            }

            if (is_numeric($current) && is_string($next)) {
                return 1;
            }

            return $current < $next ? -1 : 1;
        };

        $this->assertSame($target, $this->arr($source)->ksort($callback)->toArray());
    }

    public function testToArray()
    {
        $this->assertEquals(['foo', 'bar'], $this->arr(['foo', 'bar'])->resolve()->toArray());
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr(['foo' => 'Foo', 'bar' => 'Bar'])->resolve()->toArray());
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr((object) ['foo' => 'Foo', 'bar' => 'Bar'])->resolve()->toArray());
        $this->assertEquals(['foo'], $this->arr('foo')->resolve()->toArray());

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], $this->arr(new Bar())->resolve()->toArray());
        $this->assertEquals(['qwerty' => 'Qwerty'], $this->arr(new Baz())->resolve()->toArray());
    }

    public function testAddUnique()
    {
        $array   = ['foo'];
        $values1 = ['foo', 'bar', 'baz'];
        $values2 = 'foobar';

        $expected = ['foo', 'bar', 'baz', 'foobar'];

        $array = $this->arr($array)->addUnique($values1)->toArray();
        $array = $this->arr($array)->addUnique($values2)->toArray();

        $this->assertSame($expected, $array);
    }

    public function testUnique()
    {
        $source = ['foo', 'bar', 'baz', 'bar', 'baq', 'baz'];

        $expected = [
            0 => 'foo',
            1 => 'bar',
            2 => 'baz',
            4 => 'baq',
        ];

        $this->assertSame($expected, $this->arr($source)->unique()->toArray());
    }

    public function testMap()
    {
        $source = [
            'foo' => 11,
            'bar' => 22,
            'baz' => 33,

            'qwe' => [
                'qaz' => 11,
                'wsx' => 22,
                'edc' => 33,
            ],
        ];

        $expected = [
            'foo' => 'Foo_22',
            'bar' => 'Bar_44',
            'baz' => 'Baz_66',

            'qwe' => [
                'qaz' => 11,
                'wsx' => 22,
                'edc' => 33,
            ],
        ];

        $this->assertSame($expected, $this->arr($source)->map(static fn ($value, $key): string => Str::studly($key) . '_' . ($value * 2))->toArray());
    }

    public function testMapRecursive()
    {
        $source = [
            'foo' => 11,
            'bar' => 22,
            'baz' => 33,

            'qwe' => [
                'qaz' => 11,
                'wsx' => 22,
                'edc' => 33,
            ],
        ];

        $expected = [
            'foo' => 'Foo_22',
            'bar' => 'Bar_44',
            'baz' => 'Baz_66',

            'qwe' => [
                'qaz' => 'Qaz_22',
                'wsx' => 'Wsx_44',
                'edc' => 'Edc_66',
            ],
        ];

        $this->assertSame($expected, $this->arr($source)->map(static fn ($value, $key): string => Str::studly($key) . '_' . ($value * 2), true)->toArray());
    }

    public function testFlip()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $target = [
            'Foo'     => 'foo',
            'Bar'     => 'bar',
            'Baz'     => 'baz',
            'Num 200' => 200,
            'Num 400' => 400,
        ];

        $this->assertSame($target, $this->arr($source)->flip()->toArray());
    }

    public function testFlipArrayable()
    {
        $expected_bar = [
            'Foo' => 'first',
            'Bar' => 'second',
        ];

        $expected_baz = [
            'Qwerty' => 'qwerty',
        ];

        $this->assertSame($expected_bar, $this->arr(new Bar())->flip()->toArray());
        $this->assertSame($expected_baz, $this->arr(new Baz())->flip()->toArray());
    }

    public function testKeys()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $expected = [
            'foo',
            'bar',
            'baz',
            200,
            400,
        ];

        $this->assertSame($expected, $this->arr($source)->keys()->toArray());
    }

    public function testKeysArrayable()
    {
        $expected_bar = [
            'first',
            'second',
        ];

        $expected_baz = [
            'qwerty',
        ];

        $this->assertSame($expected_bar, $this->arr(new Bar())->keys()->toArray());
        $this->assertSame($expected_baz, $this->arr(new Baz())->keys()->toArray());
    }

    public function testPush()
    {
        $source = [
            'foo' => 'Foo',
        ];

        $expected1 = [
            'foo' => 'Foo',
            'Bar',
        ];

        $expected2 = [
            'foo' => 'Foo',
            [
                'Bar',
                'Baz',
            ],
        ];

        $expected3 = [
            'foo' => 'Foo',
            'Bar',
            'Baz',
        ];

        $this->assertSame($expected1, $this->arr($source)->push('Bar')->toArray());
        $this->assertSame($expected2, $this->arr($source)->push(['Bar', 'Baz'])->toArray());
        $this->assertSame($expected3, $this->arr($source)->push('Bar', 'Baz')->toArray());
    }

    public function testSet()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $expected = [
            'foo' => 'Foo',
            'bar' => 'Qwerty',
        ];

        $this->assertSame($expected, $this->arr($source)->set('bar', 'Qwerty')->toArray());
        $this->assertSame($expected, $this->arr($source)->set(['bar' => 'Qwerty'])->toArray());
    }

    public function testRemove()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $expected = [
            'foo' => 'Foo',
        ];

        $this->assertSame($expected, $this->arr($source)->remove('bar')->toArray());
    }

    public function testTap()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $expected1 = [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ];

        $expected2 = [
            'Foo' => 'foo',
            'Bar' => 'bar',
        ];

        $tmp = [];

        $result = $this->arr($source)->tap(static function ($value, $key) use (&$tmp) {
            $tmp[$value] = $key;
        })->toArray();

        $this->assertSame($expected1, $result);
        $this->assertSame($expected2, $tmp);
    }

    public function testReverse()
    {
        $source = ['foo', 'bar', 'baz'];

        $expected1 = ['baz', 'bar', 'foo'];
        $expected2 = [2 => 'baz', 1 => 'bar', 0 => 'foo'];

        $this->assertSame($expected1, $this->arr($source)->reverse()->toArray());
        $this->assertSame($expected2, $this->arr($source)->reverse(true)->toArray());
    }

    public function testMulti()
    {
        $source = [
            'OBJ' => new Bar(),

            'qwe' => [
                'qaz' => 11,
                'wsx' => 22,
                'edc' => 33,
            ],

            'foo' => 11,
            'bar' => 22,
            'baz' => 33,
        ];

        $expected1 = [
            'BAZ' => 33,

            'first'  => 'foo',
            'second' => 'bar',

            'qaz' => 11,

            'WASD' => 'new element',

            'baz',
        ];

        $expected2 = [
            11,
            33,

            'bar',
            'baz',
            'foo',

            'new element',
        ];

        $expected3 = [
            33,

            'foo',
            'bar',

            11,

            'new element',

            'baz',
        ];

        $expected4 = [
            'BAZ' => 33,

            'first'  => 'foo',
            'second' => 'bar',

            'qaz' => 22,

            'WASD' => 'new element',

            1 => 'bat',
        ];

        $expected5 = [
            33 => 'BAZ',

            'foo' => 'first',
            'bar' => 'second',

            11 => 'qaz',

            'new element' => 'WASD',

            'baz' => 0,
        ];

        $expected6 = [
            'BAZ',

            'first',
            'second',

            'qaz',

            'WASD',

            0,
        ];

        $array = $this->arr($source)
            ->ksort()
            ->renameKeys(static fn ($key): string => Str::upper($key))
            ->merge(['WASD' => 'New element'])
            ->resolve()
            ->except(static fn ($key): bool => ! Str::startsWith($key, ['F', 'E']))
            ->flatten(false)
            ->map(static fn ($value) => is_numeric($value) ? $value : Str::lower($value))
            ->addUnique(['foo', 'baz'])
            ->filter(static fn ($value): bool => $value !== 22);

        $this->assertSame($expected1, $array->toArray());
        $this->assertSame($expected2, $array->sort()->toArray());
        $this->assertSame($expected3, $array->values()->toArray());
        $this->assertSame($expected4, $array->push('bat')->remove(0)->set('qaz', 22)->toArray());
        $this->assertSame($expected5, $array->flip()->toArray());
        $this->assertSame($expected6, $array->keys()->toArray());
    }

    protected function arr($value = []): Arrayable
    {
        return new Arrayable($value);
    }
}
