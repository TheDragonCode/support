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
use Tests\Fixtures\Instances\Map;
use Tests\TestCase;

class MapIntoTest extends TestCase
{
    public function testMapInto()
    {
        $source = [
            ['Foo1', 'Bar1'],
            ['Foo2', 'Bar2'],
        ];

        /** @var array<Map> $mapped */
        $mapped = Arr::mapInto($source, Map::class);

        $this->assertIsArray($mapped);

        $this->assertInstanceOf(Map::class, $mapped[0]);
        $this->assertInstanceOf(Map::class, $mapped[1]);

        $this->assertSame(['Foo1', 'Bar1'], $mapped[0]->values);
        $this->assertSame(['Foo2', 'Bar2'], $mapped[1]->values);
    }
}
