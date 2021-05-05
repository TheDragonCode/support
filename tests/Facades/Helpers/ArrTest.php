<?php

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class ArrTest extends TestCase
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

        $this->assertSame(['baz' => 'Baz', 200 => 'Num 200', 400 => 'Num 400'], Arr::except($arr, static function ($key) {
            return ! Str::startsWith($key, ['foo', 'bar']);
        }));

        $this->assertSame(['foo' => 'Foo', 200 => 'Num 200', 400 => 'Num 400'], Arr::except($arr, static function ($key) {
            return ! Str::startsWith($key, 'ba');
        }));

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'], Arr::except($arr, static function ($key) {
            return ! is_numeric($key);
        }));
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

        $renamed = Arr::renameKeys($source, static function ($key) {
            return mb_strtoupper($key);
        });

        $modified = Arr::renameKeys($source, static function ($key, $value) {
            return mb_strtolower($key) . '_' . $value;
        });

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

        $renamed = Arr::renameKeysMap($source, $map);

        $this->assertSame($expected, $renamed);
    }

    public function testGet()
    {
        $this->assertEquals('bar', Arr::get(['foo' => 'bar'], 'foo'));
        $this->assertEquals('bar', Arr::get(['foo' => 'bar'], 'foo', 'bar'));
        $this->assertEquals('baz', Arr::get(['foo' => 'bar'], 'bar', 'baz'));

        $this->assertNull(Arr::get(['foo' => 'bar'], 'bar'));

        $this->assertSame('Foo', Arr::get(new Arrayable(), 'foo'));
        $this->assertSame('Bar', Arr::get(new Arrayable(), 'bar'));
        $this->assertSame('Baz', Arr::get(new Arrayable(), 'baz'));

        $this->assertNull(Arr::get(new Arrayable(), 'qwerty'));
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

        $result = Arr::merge($arr1, $arr2);

        $this->assertSame($expected, $result);
    }

    public function testLongestStringLength()
    {
        $array = ['foo', 'bar', 'foobar', 'baz'];

        $this->assertSame(6, Arr::longestStringLength($array));
    }

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
            Arr::only($arr, ['foo', 'qwerty' => ['w'], '500' => ['t', 'y']])
        );

        $this->assertSame([], Arr::only($arr, []));
        $this->assertSame([], Arr::only($arr, null));
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

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], Arr::only($arr, static function ($key) {
            return Str::startsWith($key, ['foo', 'bar']);
        }));

        $this->assertSame(['bar' => 'Bar', 'baz' => 'Baz'], Arr::only($arr, static function ($key) {
            return Str::startsWith($key, 'ba');
        }));

        $this->assertSame([200 => 'Num 200', 400 => 'Num 400'], Arr::only($arr, static function ($key) {
            return is_numeric($key);
        }));
    }

    public function testFlatten()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array));

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array));

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', null, '#baz', null], Arr::flatten($array));

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array));

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array));
    }

    public function testStoreAsArray()
    {
        $array = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];

        $path = $this->tempDirectory('array.php');

        Arr::store($array, $path);

        $loaded = require $path;

        $this->assertFileExists($path);
        $this->assertIsArray($loaded);
        $this->assertEquals($array, $loaded);
    }

    public function testStoreAsJson()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',
        ];

        $target = [
            'add key'      => 'Add key',
            'all key'      => 'All key',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,
        ];

        $path = $this->tempDirectory('array.json');

        Arr::store($source, $path, true);

        $this->assertJsonStringEqualsJsonFile($path, json_encode($target));
    }

    public function testStoreAsPrettyJson()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',
        ];

        $target = [
            'add key'      => 'Add key',
            'all key'      => 'All key',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,
        ];

        $path = $this->tempDirectory('array.json');

        Arr::store($source, $path, true, false, JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonFile($path, json_encode($target, JSON_PRETTY_PRINT));
    }

    public function testStoreAsSortedArray()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',
        ];

        $target = [
            'add key'      => 'Add key',
            'all key'      => 'All key',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,
        ];

        $path = $this->tempDirectory('sorted.php');

        Arr::storeAsArray($path, $source, true);

        $loaded = require $path;

        $this->assertIsArray($loaded);
        $this->assertEquals($target, $loaded);
    }

    public function testStoreAsSortedJson()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',
        ];

        $target = [
            'add key'      => 'Add key',
            'all key'      => 'All key',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,
        ];

        $path = $this->tempDirectory('sorted.json');

        Arr::storeAsJson($path, $source, true);

        $this->assertJsonStringEqualsJsonFile($path, json_encode($target));
    }

    public function testStoreAsSortedPrettyJson()
    {
        $source = [
            'add key' => 'Add key',
            'all key' => 'All key',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,

            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',
        ];

        $target = [
            'add key'      => 'Add key',
            'all key'      => 'All key',
            'API key'      => 'API key',
            'Are you sure' => 'Are you sure',

            'q' => 1,
            'r' => 2,
            's' => 5,
            'w' => 123,
        ];

        $path = $this->tempDirectory('sorted.json');

        Arr::storeAsJson($path, $source, true, JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonFile($path, json_encode($target, JSON_PRETTY_PRINT));
    }

    public function testSortByKeys()
    {
        $source = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];

        $sorter = ['q', 'w', 'e'];

        $expected = ['q' => 1, 'w' => 123, 'r' => 2, 's' => 5];

        $actual = Arr::sortByKeys($source, $sorter);

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

        $this->assertSame($target, Arr::sort($source));
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

        $this->assertSame($target, Arr::sort($source, $callback));
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

        $this->assertSame($target, Arr::ksort($source));
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

        $this->assertSame($target, Arr::ksort($source, $callback));
    }

    public function testExists()
    {
        $this->assertTrue(Arr::exists(['foo' => 'bar'], 'foo'));
        $this->assertFalse(Arr::exists(['foo' => 'bar'], 'bar'));

        $this->assertTrue(Arr::exists(new Arrayable(), 'foo'));
        $this->assertTrue(Arr::exists(new Arrayable(), 'bar'));
        $this->assertFalse(Arr::exists(new Arrayable(), 'qwe'));
        $this->assertFalse(Arr::exists(new Arrayable(), 'rty'));
    }

    public function testWrap()
    {
        $this->assertEquals(['data'], Arr::wrap('data'));
        $this->assertEquals(['data'], Arr::wrap(['data']));
        $this->assertEquals([1], Arr::wrap(1));
    }

    public function testToArray()
    {
        $this->assertEquals(['foo', 'bar'], Arr::toArray(['foo', 'bar']));
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], Arr::toArray(['foo' => 'Foo', 'bar' => 'Bar']));
        $this->assertEquals(['foo' => 'Foo', 'bar' => 'Bar'], Arr::toArray((object) ['foo' => 'Foo', 'bar' => 'Bar']));
        $this->assertEquals(['foo'], Arr::toArray('foo'));

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], Arr::toArray(new Bar()));
        $this->assertEquals(['qwerty' => 'Qwerty'], Arr::toArray(new Baz()));
    }

    public function testIsArrayable()
    {
        $this->assertTrue(Arr::isArrayable([]));
        $this->assertTrue(Arr::isArrayable(['foo']));
        $this->assertTrue(Arr::isArrayable(new Arrayable()));
    }

    public function testIsEmpty()
    {
        $this->assertFalse(Arr::isEmpty(''));
        $this->assertFalse(Arr::isEmpty(' '));
        $this->assertFalse(Arr::isEmpty('      '));
        $this->assertFalse(Arr::isEmpty(null));

        $this->assertFalse(Arr::isEmpty(0));
        $this->assertFalse(Arr::isEmpty('   0   '));
        $this->assertFalse(Arr::isEmpty(false));

        $this->assertTrue(Arr::isEmpty([]));
        $this->assertTrue(Arr::isEmpty(new Foo()));

        $this->assertFalse(Arr::isEmpty(new Bar()));
        $this->assertFalse(Arr::isEmpty(new Baz()));
        $this->assertFalse(Arr::isEmpty(new Baq()));
        $this->assertFalse(Arr::isEmpty(new Arrayable()));
    }

    public function testDoesntEmpty()
    {
        $this->assertTrue(Arr::doesntEmpty(''));
        $this->assertTrue(Arr::doesntEmpty(' '));
        $this->assertTrue(Arr::doesntEmpty('      '));
        $this->assertTrue(Arr::doesntEmpty(null));

        $this->assertTrue(Arr::doesntEmpty(0));
        $this->assertTrue(Arr::doesntEmpty('   0   '));
        $this->assertTrue(Arr::doesntEmpty(false));

        $this->assertFalse(Arr::doesntEmpty([]));
        $this->assertFalse(Arr::doesntEmpty(new Foo()));

        $this->assertTrue(Arr::doesntEmpty(new Bar()));
        $this->assertTrue(Arr::doesntEmpty(new Baz()));
        $this->assertTrue(Arr::doesntEmpty(new Baq()));
        $this->assertTrue(Arr::doesntEmpty(new Arrayable()));
    }

    public function testAddUnique()
    {
        $array   = ['foo'];
        $values1 = ['foo', 'bar', 'baz'];
        $values2 = 'foobar';

        $expected = ['foo', 'bar', 'baz', 'foobar'];

        $array = Arr::addUnique($array, $values1);
        $array = Arr::addUnique($array, $values2);

        $this->assertSame($expected, $array);
    }

    public function testGetKeyIfExist()
    {
        $this->assertEquals('foo', Arr::getKey(['foo' => 'bar'], 'foo'));
        $this->assertEquals('foo', Arr::getKey(['foo' => 'bar'], 'foo', 'bar'));
        $this->assertEquals('baz', Arr::getKey(['foo' => 'bar'], 'bar', 'baz'));

        $this->assertNull(Arr::get(['foo' => 'bar'], 'bar'));
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

        $this->assertSame($expected, Arr::map($source, static function ($value, $key) {
            return Str::studly($key) . '_' . ($value * 2);
        }));
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

        $this->assertSame($expected, Arr::map($source, static function ($value, $key) {
            return Str::studly($key) . '_' . ($value * 2);
        }, true));
    }
}
