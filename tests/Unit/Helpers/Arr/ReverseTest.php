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
use Tests\TestCase;

class ReverseTest extends TestCase
{
    public function testReverse()
    {
        $source = ['foo', 'bar', 'baz'];

        $expected1 = ['baz', 'bar', 'foo'];
        $expected2 = [2 => 'baz', 1 => 'bar', 0 => 'foo'];

        $this->assertSame($expected1, Arr::reverse($source));
        $this->assertSame($expected2, Arr::reverse($source, true));
    }
}
