<?php

namespace Tests\Helpers\Ables;

use Helldar\Support\Facades\Helpers\Str;
use Helldar\Support\Helpers\Ables\Arrayable;
use Helldar\Support\Helpers\Ables\Arrayable as Helper;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class ArrayableTest extends TestCase
{
    public function testOf()
    {
        $this->assertSame([], $this->arr()->of()->get());
        $this->assertInstanceOf(Helper::class, $this->arr()->of());

        $this->assertSame([], $this->arr()->of(null)->get());
        $this->assertInstanceOf(Helper::class, $this->arr()->of(null));

        $this->assertSame([], $this->arr()->of([])->get());
        $this->assertInstanceOf(Helper::class, $this->arr()->of([]));

        $this->assertSame([], $this->arr()->of('')->get());
        $this->assertInstanceOf(Helper::class, $this->arr()->of(''));
    }

    public function testGet()
    {
        $obj = new Foo();

        $this->assertSame(['foo' => 'bar'], $this->arr(['foo' => 'bar'])->get());
        $this->assertSame(compact('obj'), $this->arr(compact('obj'))->get());
    }

    public function testExcept()
    {
        $array = [
            'foo' => 123,
            'bar' => 456,
            'baz' => 789,
        ];

        $this->assertSame(['bar' => 456, 'baz' => 789], $this->arr($array)->except('foo')->get());
        $this->assertSame(['bar' => 456, 'baz' => 789], $this->arr($array)->except(['foo'])->get());

        $this->assertSame(['bar' => 456], $this->arr($array)->except(['foo', 'baz'])->get());

        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], $this->arr($array)->except([])->get());
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], $this->arr($array)->except(null)->get());
        $this->assertSame(['foo' => 123, 'bar' => 456, 'baz' => 789], $this->arr($array)->except(123)->get());

        $this->assertSame([], $this->arr([])->except([])->get());
        $this->assertSame([], $this->arr([])->except('')->get());
        $this->assertSame([], $this->arr([])->except(['foo', 'bar'])->get());
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

        $this->assertSame(['baz' => 'Baz', 200 => 'Num 200', 400 => 'Num 400'], $this->arr($array)->except(static function ($key) {
            return ! Str::startsWith($key, ['foo', 'bar']);
        })->get());

        $this->assertSame(['foo' => 'Foo', 200 => 'Num 200', 400 => 'Num 400'], $this->arr($array)->except(static function ($key) {
            return ! Str::startsWith($key, 'ba');
        })->get());

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'], $this->arr($array)->except(static function ($key) {
            return ! is_numeric($key);
        })->get());
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

        $renamed = $this->arr($source)->renameKeys(static function ($key) {
            return mb_strtoupper($key);
        })->get();

        $modified = $this->arr($source)->renameKeys(static function ($key, $value) {
            return mb_strtolower($key) . '_' . $value;
        })->get();

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

        $renamed = $this->arr($source)->renameKeysMap($map)->get();

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
            0     => 'Foo',
            2     => 'Bar bar',
            400   => 'Baz',
            500   => 'Foo bar',
            600   => ['bar' => 'Bar', 'baz' => 'Baz', 'foo' => 'Foo'],
            700   => ['aaa' => 'AAA'],
            'foo' => 'Bar',
        ];

        $result1 = $this->arr($arr1)->merge($arr2)->get();
        $result2 = $this->arr($arr1)->merge($arr1, $arr2)->get();
        $result3 = $this->arr()->merge($arr1, $arr2)->get();

        $this->assertSame($expected, $result1);
        $this->assertSame($expected, $result2);
        $this->assertSame($expected, $result3);
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

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr($array)->only(['foo', 'bar'])->get());
        $this->assertSame(['bar' => 'Bar', 200 => 'Num 200'], $this->arr($array)->only(['bar', 200])->get());

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 'qwerty' => ['q' => 'Q', 'w' => 'W', 'e' => 'E']],
            $this->arr($array)->only(['foo', 'baz', 'qwerty'])->get()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'baz' => 'Baz', 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            $this->arr($array)->only(['foo', 'baz', 500])->get()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['r' => 'R', 't' => 'T', 'y' => 'Y']],
            $this->arr($array)->only(['foo', 'qwerty' => ['w'], 500])->get()
        );

        $this->assertSame(
            ['foo' => 'Foo', 'qwerty' => ['w' => 'W'], 500 => ['t' => 'T', 'y' => 'Y']],
            $this->arr($array)->only(['foo', 'qwerty' => ['w'], 500 => ['t', 'y']])->get()
        );

        $this->assertSame([], $this->arr($array)->only([])->get());
        $this->assertSame([], $this->arr($array)->only(null)->get());
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

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr($array)->only(static function ($key) {
            return Str::startsWith($key, ['foo', 'bar']);
        })->get());

        $this->assertSame(['bar' => 'Bar', 'baz' => 'Baz'], $this->arr($array)->only(static function ($key) {
            return Str::startsWith($key, 'ba');
        })->get());

        $this->assertSame([200 => 'Num 200', 400 => 'Num 400'], $this->arr($array)->only(static function ($key) {
            return is_numeric($key);
        })->get());
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

        $result = $this->arr($source)->filter(static function ($value, $key) {
            return Str::contains($value, 200) || Str::startsWith($key, 'b');
        }, ARRAY_FILTER_USE_BOTH)->get();

        $this->assertSame($target, $result);
    }

    public function testFlatten()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->get());

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->get());

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', null, '#baz', null], $this->arr($array)->flatten()->get());

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->get());

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten()->get());
    }

    public function testFlattenDoesntIgnore()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten(false)->get());

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#baz'], $this->arr($array)->flatten(false)->get());

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', '#baz', null], $this->arr($array)->flatten(false)->get());

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten(false)->get());

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], $this->arr($array)->flatten(false)->get());
    }

    public function testSortByKeys()
    {
        $source = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];

        $sorter = ['q', 'w', 'e'];

        $expected = ['q' => 1, 'w' => 123, 'r' => 2, 's' => 5];

        $actual = $this->arr($source)->sortByKeys($sorter)->get();

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

        $this->assertSame($target, $this->arr($source)->sort()->get());
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

        $this->assertSame($target, $this->arr($source)->sort($callback)->get());
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

        $this->assertSame($target, $this->arr($source)->ksort()->get());
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

        $this->assertSame($target, $this->arr($source)->ksort($callback)->get());
    }

    public function testToArray()
    {
        $this->assertEquals(['foo', 'bar'], $this->arr(['foo', 'bar'])->toArray()->get());
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr(['foo' => 'Foo', 'bar' => 'Bar'])->toArray()->get());
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], $this->arr((object) ['foo' => 'Foo', 'bar' => 'Bar'])->toArray()->get());
        $this->assertEquals(['foo'], $this->arr('foo')->toArray()->get());

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], $this->arr(new Bar())->toArray()->get());
        $this->assertEquals(['qwerty' => 'Qwerty'], $this->arr(new Baz())->toArray()->get());
    }

    public function testAddUnique()
    {
        $array   = ['foo'];
        $values1 = ['foo', 'bar', 'baz'];
        $values2 = 'foobar';

        $expected = ['foo', 'bar', 'baz', 'foobar'];

        $array = $this->arr($array)->addUnique($values1)->get();
        $array = $this->arr($array)->addUnique($values2)->get();

        $this->assertSame($expected, $array);
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

        $this->assertSame($expected, $this->arr($source)->map(static function ($value, $key) {
            return Str::studly($key) . '_' . ($value * 2);
        })->get());
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

        $this->assertSame($expected, $this->arr($source)->map(static function ($value, $key) {
            return Str::studly($key) . '_' . ($value * 2);
        }, true)->get());
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

        $this->assertSame($expected1, $this->arr($source)->push('Bar')->get());
        $this->assertSame($expected2, $this->arr($source)->push(['Bar', 'Baz'])->get());
        $this->assertSame($expected3, $this->arr($source)->push('Bar', 'Baz')->get());
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

        $this->assertSame($expected, $this->arr($source)->set('bar', 'Qwerty')->get());
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

        $this->assertSame($expected, $this->arr($source)->remove('bar')->get());
    }

    public function testCombine()
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

        $array = $this->arr($source)
            ->ksort()
            ->renameKeys(static function ($key) {
                return Str::upper($key);
            })
            ->merge(['WASD' => 'New element'])
            ->toArray()
            ->except(static function ($key) {
                return ! Str::startsWith($key, ['F', 'E']);
            })
            ->flatten(false)
            ->map(static function ($value) {
                return is_numeric($value) ? $value : Str::lower($value);
            })
            ->addUnique(['foo', 'baz'])
            ->filter(static function ($value) {
                return $value !== 22;
            });

        $this->assertSame($expected1, $array->get());
        $this->assertSame($expected2, $array->sort()->get());
        $this->assertSame($expected3, $array->values()->get());
        $this->assertSame($expected4, $array->push('bat')->remove(0)->set('qaz', 22)->get());
    }

    protected function arr($value = []): Arrayable
    {
        return new Arrayable($value);
    }
}
