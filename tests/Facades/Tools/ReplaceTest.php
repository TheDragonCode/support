<?php
/*
 * This file is part of the "dragon-code/support" project.
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
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Facades\Tools;

use DragonCode\Support\Facades\Tools\Replace;
use Tests\TestCase;

class ReplaceTest extends TestCase
{
    public function testToFormat()
    {
        $this->assertSame('foo', Replace::toFormat('foo'));
        $this->assertSame('foo', Replace::toFormat('foo', ''));
        $this->assertSame('foo', Replace::toFormat('foo', '%s'));
        $this->assertSame('{foo}', Replace::toFormat('foo', '{%s}'));
        $this->assertSame('_foo_', Replace::toFormat('foo', '_%s_'));
    }

    public function testToFormatArray()
    {
        $this->assertSame(['foo', 'bar', 'baz'], Replace::toFormatArray(['foo', 'bar', 'baz']));
        $this->assertSame(['foo', 'bar', 'baz'], Replace::toFormatArray(['foo', 'bar', 'baz'], ''));
        $this->assertSame(['foo', 'bar', 'baz'], Replace::toFormatArray(['foo', 'bar', 'baz']), '%s');

        $this->assertSame(['{foo}', '{bar}', '{baz}'], Replace::toFormatArray(['foo', 'bar', 'baz'], '{%s}'));

        $this->assertSame(['_foo_', '_bar_', '_baz_'], Replace::toFormatArray(['foo', 'bar', 'baz'], '_%s_'));
    }
}
