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

class UniqueTest extends TestCase
{
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
}
