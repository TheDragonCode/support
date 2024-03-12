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

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class LastTest extends TestCase
{
    public function testLast()
    {
        $array = [100, 200, 300];

        $last = Arr::last($array, static fn ($value) => $value < 250);
        $this->assertEquals(200, $last);

        $last = Arr::last($array, static fn ($value, $key) => $key < 2);
        $this->assertEquals(200, $last);

        $this->assertEquals(300, Arr::last($array));
    }
}
