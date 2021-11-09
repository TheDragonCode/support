<?php
/*
 * This file is part of the "andrey-helldar/support" project.
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
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Facades\Helpers;

use ArrayObject;
use Helldar\Support\Facades\Helpers\Ables\Arrayable as ArrayableHelper;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ArrTest extends TestCase
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

        $this->assertNull(Arr::get(new Arrayable(), 'qwerty'));

        $array = ['products.desk' => ['price' => 100]];
        $this->assertEquals(['price' => 100], Arr::get($array, 'products.desk'));

        $array = ['products' => ['desk' => ['price' => 100]]];
        $value = Arr::get($array, 'products.desk');
        $this->assertEquals(['price' => 100], $value);

        // Test null array values
        $array = ['foo' => null, 'bar' => ['baz' => null]];
        $this->assertNull(Arr::get($array, 'foo', 'default'));
        $this->assertNull(Arr::get($array, 'bar.baz', 'default'));

        // Test direct ArrayAccess object
        $array             = ['products' => ['desk' => ['price' => 100]]];
        $arrayAccessObject = new ArrayObject($array);
        $value             = Arr::get($arrayAccessObject, 'products.desk');
        $this->assertEquals(['price' => 100], $value);

        // Test array containing ArrayAccess object
        $arrayAccessChild = new ArrayObject(['products' => ['desk' => ['price' => 100]]]);
        $array            = ['child' => $arrayAccessChild];
        $value            = Arr::get($array, 'child.products.desk');
        $this->assertEquals(['price' => 100], $value);

        // Test array containing multiple nested ArrayAccess objects
        $arrayAccessChild  = new ArrayObject(['products' => ['desk' => ['price' => 100]]]);
        $arrayAccessParent = new ArrayObject(['child' => $arrayAccessChild]);
        $array             = ['parent' => $arrayAccessParent];
        $value             = Arr::get($array, 'parent.child.products.desk');
        $this->assertEquals(['price' => 100], $value);

        // Test missing ArrayAccess object field
        $arrayAccessChild  = new ArrayObject(['products' => ['desk' => ['price' => 100]]]);
        $arrayAccessParent = new ArrayObject(['child' => $arrayAccessChild]);
        $array             = ['parent' => $arrayAccessParent];
        $value             = Arr::get($array, 'parent.child.desk');
        $this->assertNull($value);

        // Test missing ArrayAccess object field
        $arrayAccessObject = new ArrayObject(['products' => ['desk' => null]]);
        $array             = ['parent' => $arrayAccessObject];
        $value             = Arr::get($array, 'parent.products.desk.price');
        $this->assertNull($value);

        // Test null ArrayAccess object fields
        $array = new ArrayObject(['foo' => null, 'bar' => new ArrayObject(['baz' => null])]);
        $this->assertNull(Arr::get($array, 'foo', 'default'));
        $this->assertNull(Arr::get($array, 'bar.baz', 'default'));

        // Test null key returns the whole array
        $array = ['foo', 'bar'];
        $this->assertEquals($array, Arr::get($array, null));

        // Test $array not an array
        $this->assertSame('default', Arr::get(null, 'foo', 'default'));
        $this->assertSame('default', Arr::get(false, 'foo', 'default'));

        // Test $array not an array and key is null
        $this->assertSame('default', Arr::get(null, null, 'default'));

        // Test $array is empty and key is null
        $this->assertEmpty(Arr::get([], null));
        $this->assertEmpty(Arr::get([], null, 'default'));

        // Test numeric keys
        $array = [
            'products' => [
                ['name' => 'desk'],
                ['name' => 'chair'],
            ],
        ];
        $this->assertSame('desk', Arr::get($array, 'products.0.name'));
        $this->assertSame('chair', Arr::get($array, 'products.1.name'));

        // Test return default value for non-existing key.
        $array = ['names' => ['developer' => 'taylor']];
        $this->assertSame('dayle', Arr::get($array, 'names.otherDeveloper', 'dayle'));
    }

    public function testMerge()
    {
        $arr1 = [
            'foo' => 'Bar',
            '0'   => 'Foo',
            '2'   => 'Bar',
            '400' => 'Baz',
            600   => ['foo' => 'Foo', 'bar' => 'Bar'],
            700   => 'Qwerty',
        ];

        $arr2 = [
            '2'   => 'Bar bar',
            '500' => 'Foo bar',
            '600' => ['baz' => 'Baz'],
            '700' => ['aaa' => 'AAA'],
            800   => ['bbb' => 'BBB'],
        ];

        $expected = [
            'foo' => 'Bar',
            0     => 'Foo',
            2     => 'Bar bar',
            400   => 'Baz',
            600   => ['foo' => 'Foo', 'bar' => 'Bar', 'baz' => 'Baz'],
            700   => ['aaa' => 'AAA'],
            500   => 'Foo bar',
            800   => ['bbb' => 'BBB'],
        ];

        $result = Arr::merge($arr1, $arr2);

        $this->assertSame($expected, $result);
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

        $this->assertSame([
            'foo'    => 'Foo',
            'bar'    => 'Bar',
            'qwerty' => [
                'q' => 'Q',
                'e' => 'E',
            ],
        ], Arr::only($arr, [
            'foo',
            'bar',
            'qwerty'        => ['q', 'e'],
            'unknown_key',
            'unknown_array' => ['foo', 'bar'],
        ]));
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

        $result = Arr::filter($source, static function ($value, $key) {
            return Str::contains($value, 200) || Str::startsWith($key, 'b');
        }, ARRAY_FILTER_USE_BOTH);

        $this->assertSame($target, $result);
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

        $this->assertSame($target, Arr::flip($source));
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

        $this->assertSame($expected_bar, Arr::flip(new Bar()));
        $this->assertSame($expected_baz, Arr::flip(new Baz()));
    }

    public function testValues()
    {
        $source = [
            'foo' => 'Foo',
            'bar' => 'Bar',
            'baz' => 'Baz',
            200   => 'Num 200',
            400   => 'Num 400',
        ];

        $expected = [
            'Foo',
            'Bar',
            'Baz',
            'Num 200',
            'Num 400',
        ];

        $this->assertSame($expected, Arr::values($source));
    }

    public function testValuesArrayable()
    {
        $expected_bar = [
            'Foo',
            'Bar',
        ];

        $expected_baz = [
            'Qwerty',
        ];

        $this->assertSame($expected_bar, Arr::values(new Bar()));
        $this->assertSame($expected_baz, Arr::values(new Baz()));
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

        $this->assertSame($expected, Arr::keys($source));
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

        $this->assertSame($expected_bar, Arr::keys(new Bar()));
        $this->assertSame($expected_baz, Arr::keys(new Baz()));
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

    public function testFlattenDoesntIgnore()
    {
        // Flat arrays are unaffected
        $array = ['#foo', '#bar', '#baz'];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array, false));

        // Nested arrays are flattened with existing flat items
        $array = [['#foo', '#bar'], '#baz'];
        $this->assertEquals(['#foo', '#baz'], Arr::flatten($array, false));

        // Flattened array includes "null" items
        $array = [['#foo', null], '#baz', null];
        $this->assertEquals(['#foo', '#baz', null], Arr::flatten($array, false));

        // Sets of nested arrays are flattened
        $array = [['#foo', '#bar'], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array, false));

        // Deeply nested arrays are flattened
        $array = [['#foo', ['#bar']], ['#baz']];
        $this->assertEquals(['#foo', '#bar', '#baz'], Arr::flatten($array, false));
    }

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

        $this->assertTrue(Arr::exists(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.baz'));
        $this->assertFalse(Arr::exists(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.qwerty'));
    }

    public function testExistsWithoutDot()
    {
        $this->assertTrue(Arr::existsWithoutDot(['foo' => 'bar'], 'foo'));
        $this->assertFalse(Arr::existsWithoutDot(['foo' => 'bar'], 'bar'));

        $this->assertTrue(Arr::existsWithoutDot(new Arrayable(), 'foo'));
        $this->assertTrue(Arr::existsWithoutDot(new Arrayable(), 'bar'));
        $this->assertFalse(Arr::existsWithoutDot(new Arrayable(), 'qwe'));
        $this->assertFalse(Arr::existsWithoutDot(new Arrayable(), 'rty'));

        $this->assertFalse(Arr::existsWithoutDot(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.baz'));
        $this->assertFalse(Arr::existsWithoutDot(['foo' => ['bar' => ['baz' => 'value']]], 'foo.bar.qwerty'));
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

        $object = ArrayableHelper::of(['first' => 'Foo', 'second' => 'Bar']);

        $this->assertEquals(['first' => 'Foo', 'second' => 'Bar'], Arr::toArray($object));
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

    public function testUnique()
    {
        $source = ['foo', 'bar', 'baz', 'bar', 'baq', 'baz'];

        $expected = [
            0 => 'foo',
            1 => 'bar',
            2 => 'baz',
            4 => 'baq',
        ];

        $this->assertSame($expected, Arr::unique($source));
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

        $this->assertSame($expected1, Arr::push($source, 'Bar'));
        $this->assertSame($expected2, Arr::push($source, ['Bar', 'Baz']));
        $this->assertSame($expected3, Arr::push($source, 'Bar', 'Baz'));
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

        $this->assertSame($expected, Arr::set($source, 'bar', 'Qwerty'));
        $this->assertSame($expected, Arr::set($source, ['bar' => 'Qwerty']));
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

        $this->assertSame($expected, Arr::remove($source, 'bar'));
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

        $result = Arr::tap($source, static function ($value, $key) use (&$tmp) {
            $tmp[$value] = $key;
        });

        $this->assertSame($expected1, $result);
        $this->assertSame($expected2, $tmp);
    }
}
