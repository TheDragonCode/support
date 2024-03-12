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

class SetTest extends TestCase
{
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
}
