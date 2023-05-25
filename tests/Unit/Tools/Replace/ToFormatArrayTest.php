<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Tools\Replace;

use DragonCode\Support\Facades\Tools\Replace;
use Tests\TestCase;

class ToFormatArrayTest extends TestCase
{
    public function testToFormatArray()
    {
        $this->assertSame(['foo', 'bar', 'baz'], Replace::toFormatArray(['foo', 'bar', 'baz']));
        $this->assertSame(['foo', 'bar', 'baz'], Replace::toFormatArray(['foo', 'bar', 'baz'], ''));
        $this->assertSame(['foo', 'bar', 'baz'], Replace::toFormatArray(['foo', 'bar', 'baz']), '%s');

        $this->assertSame(['{foo}', '{bar}', '{baz}'], Replace::toFormatArray(['foo', 'bar', 'baz'], '{%s}'));

        $this->assertSame(['_foo_', '_bar_', '_baz_'], Replace::toFormatArray(['foo', 'bar', 'baz'], '_%s_'));
    }
}
