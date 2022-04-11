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

class StoreAsJsonTest extends TestCase
{
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
}
