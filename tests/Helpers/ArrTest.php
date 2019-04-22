<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Arr;
use Tests\TestCase;

class ArrTest extends TestCase
{
    public function testAddUnique()
    {
        $array   = ['foo'];
        $values1 = ['foo', 'bar', 'baz'];
        $values2 = 'foobar';

        $expected = ['foo', 'bar', 'baz', 'foobar'];

        $array = Arr::addUnique($array, $values1);
        $array = Arr::addUnique($array, $values2);

        $this->assertEquals($expected, $array);
    }

    public function testStore()
    {
        $array = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
        $path  = './build/arr.php';

        Arr::store($array, $path);

        $loaded = require $path;

        $this->assertIsArray($loaded);
        $this->assertEquals($array, $loaded);
    }

    public function testStoreAsJson()
    {
        $array = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
        $path  = './build/arr.json';

        Arr::store($array, $path, true);

        $this->assertJsonStringEqualsJsonFile($path, \json_encode($array));
    }

    public function testSizeOfMaxValue()
    {
        $array = ['foo', 'bar', 'foobar', 'baz'];

        $result = Arr::sizeOfMaxValue($array);

        $this->assertEquals(6, $result);
    }

    public function testSortByKeysArray()
    {
        $source = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
        $sorter = ['q', 'w', 'e'];

        $expected = ['q' => 1, 'w' => 123, 'r' => 2, 's' => 5];

        $actual = Arr::sortByKeysArray($source, $sorter);

        $this->assertEquals($expected, $actual);
    }

    public function testRenameKeys()
    {
        $source = [
            'foo' => 123,
            'BaR' => 456,
            'BAZ' => 789,
        ];

        $expected = [
            'FOO' => 123,
            'BAR' => 456,
            'BAZ' => 789,
        ];

        $renamed = Arr::renameKeys($source, 'mb_strtoupper');

        $this->assertEquals($expected, $renamed);
    }
}
