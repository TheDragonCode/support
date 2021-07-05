<?php

namespace Tests\Tools;

use Helldar\Support\Tools\Replace as Tool;
use Tests\TestCase;

class ReplaceTest extends TestCase
{
    public function testToFormat()
    {
        $this->assertSame('foo', $this->replace()->toFormat('foo'));
        $this->assertSame('foo', $this->replace()->toFormat('foo', ''));
        $this->assertSame('foo', $this->replace()->toFormat('foo', '%s'));
        $this->assertSame('{foo}', $this->replace()->toFormat('foo', '{%s}'));
        $this->assertSame('_foo_', $this->replace()->toFormat('foo', '_%s_'));
    }

    public function testToFormatArray()
    {
        $this->assertSame(['foo', 'bar', 'baz'], $this->replace()->toFormatArray(['foo', 'bar', 'baz']));
        $this->assertSame(['foo', 'bar', 'baz'], $this->replace()->toFormatArray(['foo', 'bar', 'baz'], ''));
        $this->assertSame(['foo', 'bar', 'baz'], $this->replace()->toFormatArray(['foo', 'bar', 'baz']), '%s');

        $this->assertSame(['{foo}', '{bar}', '{baz}'], $this->replace()->toFormatArray(['foo', 'bar', 'baz'], '{%s}'));

        $this->assertSame(['_foo_', '_bar_', '_baz_'], $this->replace()->toFormatArray(['foo', 'bar', 'baz'], '_%s_'));
    }

    protected function replace(): Tool
    {
        return new Tool();
    }
}
