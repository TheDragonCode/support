<?php

namespace Tests\Facades\Tools;

use Helldar\Support\Facades\Tools\Replace;
use Tests\TestCase;

final class ReplaceTest extends TestCase
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
