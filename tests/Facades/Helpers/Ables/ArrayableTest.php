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

namespace Tests\Facades\Helpers\Ables;

use DragonCode\Support\Facades\Helpers\Ables\Arrayable;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Arrayable as Helper;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ArrayableTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame([], Arrayable::of()->get());
        $this->assertInstanceOf(Helper::class, Arrayable::of());

        $this->assertSame([], Arrayable::of(null)->get());
        $this->assertInstanceOf(Helper::class, Arrayable::of(null));

        $this->assertSame([], Arrayable::of([])->get());
        $this->assertInstanceOf(Helper::class, Arrayable::of([]));

        $this->assertSame([], Arrayable::of('')->get());
        $this->assertInstanceOf(Helper::class, Arrayable::of(''));
    }

    public function testGet()
    {
        $obj = new Foo();

        $this->assertSame(['foo' => 'bar'], Arrayable::of(['foo' => 'bar'])->get());
        $this->assertSame(compact('obj'), Arrayable::of(compact('obj'))->get());
    }

    public function testExcept()
    {
        $array = [
            'foo' => 123,
            'bar' => 456,
            'baz' => 789,
        ];

        $this->assertSame(['bar' => 456, 'baz' => 789], Arrayable::of($array)->except('foo')->get());
        $this->assertSame(['bar' => 456, 'baz' => 789], Arrayable::of($array)->except(['foo'])->get());

        $this->assertSame(['bar' => 456], Arrayable::of($array)->except(['foo', 'baz'])->get());

        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], Arrayable::of($array)->except([])->get());
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], Arrayable::of($array)->except(null)->get());
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], Arrayable::of($array)->except(123)->get());

        $this->assertSame([], Arrayable::of([])->except([])->get());
        $this->assertSame([], Arrayable::of([])->except('')->get());
        $this->assertSame([], Arrayable::of([])->except(['foo', 'bar'])->get());
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

        $this->assertSame(['baz' => 'Baz', 200 => 'Num 200', 400 => 'Num 400'], Arrayable::of($array)->except(
            static fn ($key) => ! Str::startsWith($key, ['foo', 'bar']))->get()
        );

        $this->assertSame(['foo' => 'Foo', 200 => 'Num 200', 400 => 'Num 400'], Arrayable::of($array)->except(
            static fn ($key) => ! Str::startsWith($key, 'ba'))->get()
        );

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'], Arrayable::of($array)->except(
            static fn ($key) => ! is_numeric($key))->get()
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

        $renamed = Arrayable::of($source)->renameKeys(static fn ($key) => mb_strtoupper($key))->get();

        $modified = Arrayable::of($source)->renameKeys(static fn ($key, $value) => mb_strtolower($key) . '_' . $value)->get();

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

        $renamed = Arrayable::of($source)->renameKeysMap($map)->get();

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

        $result1 = Arrayable::of($arr1)->merge($arr2)->get();
        $result2 = Arrayable::of($arr1)->merge($arr1, $arr2)->get();
        $result3 = Arrayable::merge($arr1, $arr2)->get();

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

        $result = Arrayable::of($arr1)->combine($arr2)->get();

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

        $result = Arrayable::of($arr1)->combine($arr2)->get();

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

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], Arrayable::of($array)->only(['foo', 'bar'])->get());
        $this->assertSame(['bar' => 'Bar', 200 => 'Num 200'], Arrayable::of($array)->only(['bar', 200])->get());

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 'qwerty' => ['q' => 'Q', 'w' => 'W', 'e' => 'E']],
            Arrayable::of($array)->only(['foo', 'baz', 'qwerty'])->get()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            Arrayable::of($array)->only(['foo', 'baz', 500])->get()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            Arrayable::of($array)->only(['foo', 'qwerty' => ['w'], 500])->get()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['t' => 'T', 'y' => 'Y']],
            Arrayable::of($array)->only(['foo', 'qwerty' => ['w'], 500 => ['t', 'y']])->get()
        );

        $this->assertSame([], Arrayable::of($array)->only([])->get());
        $this->assertSame([], Arrayable::of($array)->only(null)->get());
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

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], Arrayable::of($array)->only(
            static fn ($key) => Str::startsWith($key, ['foo', 'bar']))->get()
        );

        $this->assertSame(['bar' => 'Bar', 'baz' => 'Baz'], Arrayable::of($array)->only(
            static fn ($key) => Str::startsWith($key, 'ba'))->get()
        );

        $this->assertSame([200 => 'Num 200', 400 => 'Num 400'], Arrayable::of($array)->only(
            static fn ($key) => is_numeric($key))->get()
        );
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

        $result = Arrayable::of($source)->filter(
            static fn ($value, $key) => Str::contains($value, 200) || Str::startsWith($key, 'b')
            , ARRAY_FILTER_USE_BOTH)->get();

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
        ];

        $result = Arrayable::of($source)->filter()->get();

        $this->assertSame($expected, $result);
    }

    public function testFlatten()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten()->get());

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten()->get());

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', null, '#baz', null], Arrayable::of($array)->flatten()->get());

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten()->get());

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten()->get());
    }

    public function testFlattenDoesntIgnore()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten(false)->get());

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#baz'], Arrayable::of($array)->flatten(false)->get());

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', '#baz', null], Arrayable::of($array)->flatten(false)->get());

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten(false)->get());

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arrayable::of($array)->flatten(false)->get());
    }

    public function testSortByKeys()
    {
        $source = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];

        $sorter = ['q', 'w', 'e'];

        $expected = ['q' => 1, 'w' => 123, 'r' => 2, 's' => 5];

        $actual = Arrayable::of($source)->sortByKeys($sorter)->get();

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

        $this->assertSame($target, Arrayable::of($source)->sort()->get());
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

        $this->assertSame($target, Arrayable::of($source)->sort($callback)->get());
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

        $this->assertSame($target, Arrayable::of($source)->ksort()->get());
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

        $this->assertSame($target, Arrayable::of($source)->ksort($callback)->get());
    }

    public function testToArray()
    {
        $this->assertEquals(['foo', 'bar'], Arrayable::of(['foo', 'bar'])->toArray()->get());
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], Arrayable::of(['foo' => 'Foo', 'bar' => 'Bar'])->toArray()->get());
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], Arrayable::of((object) ['foo' => 'Foo', 'bar' => 'Bar'])->toArray()->get());
        $this->assertEquals(['foo'], Arrayable::of('foo')->toArray()->get());

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], Arrayable::of(new Bar())->toArray()->get());
        $this->assertEquals(['qwerty' => 'Qwerty'], Arrayable::of(new Baz())->toArray()->get());
    }

    public function testAddUnique()
    {
        $array   = ['foo'];
        $values1 = ['foo', 'bar', 'baz'];
        $values2 = 'foobar';

        $expected = ['foo', 'bar', 'baz', 'foobar'];

        $array = Arrayable::of($array)->addUnique($values1)->get();
        $array = Arrayable::of($array)->addUnique($values2)->get();

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

        $this->assertSame($expected, Arrayable::of($source)->unique()->get());
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

        $this->assertSame($expected, Arrayable::of($source)->map(
            static fn ($value, $key) => Str::studly($key) . '_' . ($value * 2))->get()
        );
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

        $this->assertSame($expected, Arrayable::of($source)->map(
            static fn ($value, $key) => Str::studly($key) . '_' . ($value * 2), true)->get()
        );
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

        $this->assertSame($target, Arrayable::of($source)->flip()->get());
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

        $this->assertSame($expected_bar, Arrayable::of(new Bar())->flip()->get());
        $this->assertSame($expected_baz, Arrayable::of(new Baz())->flip()->get());
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

        $this->assertSame($expected, Arrayable::of($source)->keys()->get());
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

        $this->assertSame($expected_bar, Arrayable::of(new Bar())->keys()->get());
        $this->assertSame($expected_baz, Arrayable::of(new Baz())->keys()->get());
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

        $this->assertSame($expected1, Arrayable::of($source)->push('Bar')->get());
        $this->assertSame($expected2, Arrayable::of($source)->push(['Bar', 'Baz'])->get());
        $this->assertSame($expected3, Arrayable::of($source)->push('Bar', 'Baz')->get());
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

        $this->assertSame($expected, Arrayable::of($source)->set('bar', 'Qwerty')->get());
        $this->assertSame($expected, Arrayable::of($source)->set(['bar' => 'Qwerty'])->get());
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

        $this->assertSame($expected, Arrayable::of($source)->remove('bar')->get());
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

        $result = Arrayable::of($source)->tap(static function ($value, $key) use (&$tmp) {
            $tmp[$value] = $key;
        })->get();

        $this->assertSame($expected1, $result);
        $this->assertSame($expected2, $tmp);
    }

    public function testReverse()
    {
        $source = ['foo', 'bar', 'baz'];

        $expected1 = ['baz', 'bar', 'foo'];
        $expected2 = [2 => 'baz', 1 => 'bar', 0 => 'foo'];

        $this->assertSame($expected1, Arrayable::of($source)->reverse()->get());
        $this->assertSame($expected2, Arrayable::of($source)->reverse(true)->get());
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

        $array = Arrayable::of($source)
            ->ksort()
            ->renameKeys(static fn ($key): string => Str::upper($key))
            ->merge(['WASD' => 'New element'])
            ->toArray()
            ->except(static fn ($key): bool => ! Str::startsWith($key, ['F', 'E']))
            ->flatten(false)
            ->map(static fn ($value) => is_numeric($value) ? $value : Str::lower($value))
            ->addUnique(['foo', 'baz'])
            ->filter(static fn ($value): bool => $value !== 22);

        $this->assertSame($expected1, $array->get());
        $this->assertSame($expected2, $array->sort()->get());
        $this->assertSame($expected3, $array->values()->get());
        $this->assertSame($expected4, $array->push('bat')->remove(0)->set('qaz', 22)->get());
        $this->assertSame($expected5, $array->flip()->get());
        $this->assertSame($expected6, $array->keys()->get());
    }
}
