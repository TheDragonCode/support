<?php

namespace Tests\Tools;

use Helldar\Support\Tools\Sorter as Tool;
use Tests\TestCase;

final class SorterTest extends TestCase
{
    public function testSpecialCharsStrict()
    {
        $this->assertIsArray($this->sorter()->specialChars());

        $this->assertTrue(in_array(' ', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('*', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('-', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('_', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('=', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('\\', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('/', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('|', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('~', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('`', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('+', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array(':', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array(';', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('@', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('#', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('$', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('%', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('^', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('&', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('?', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('!', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('(', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array(')', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('{', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('}', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('[', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array(']', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('§', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('№', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('<', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('>', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array('.', $this->sorter()->specialChars(), true));
        $this->assertTrue(in_array(',', $this->sorter()->specialChars(), true));

        $this->assertFalse(in_array(0, $this->sorter()->specialChars(), true));

        $this->assertFalse(in_array('foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('bar', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('baz', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('foo bar', $this->sorter()->specialChars(), true));

        $this->assertFalse(in_array(' foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('*foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('-foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('_foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('=foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('\\foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('/foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('|foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('~foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('`foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('+foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array(':foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array(';foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('@foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('#foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('$foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('%foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('^foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('&foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('?foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('!foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('(foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array(')foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('{foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('}foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('[foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array(']foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('§foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('№foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('<foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('>foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array('.foo', $this->sorter()->specialChars(), true));
        $this->assertFalse(in_array(',foo', $this->sorter()->specialChars(), true));
    }

    public function testSpecialChars()
    {
        $this->assertIsArray($this->sorter()->specialChars());

        $this->assertTrue(in_array(' ', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('*', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('-', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('_', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('=', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('\\', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('/', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('|', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('~', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('`', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('+', $this->sorter()->specialChars()));
        $this->assertTrue(in_array(':', $this->sorter()->specialChars()));
        $this->assertTrue(in_array(';', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('@', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('#', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('$', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('%', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('^', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('&', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('?', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('!', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('(', $this->sorter()->specialChars()));
        $this->assertTrue(in_array(')', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('{', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('}', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('[', $this->sorter()->specialChars()));
        $this->assertTrue(in_array(']', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('§', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('№', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('<', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('>', $this->sorter()->specialChars()));
        $this->assertTrue(in_array('.', $this->sorter()->specialChars()));
        $this->assertTrue(in_array(',', $this->sorter()->specialChars()));

        $this->assertFalse(in_array('foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('bar', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('baz', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('foo bar', $this->sorter()->specialChars()));

        $this->assertFalse(in_array(' foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('*foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('-foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('_foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('=foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('\\foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('/foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('|foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('~foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('`foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('+foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array(':foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array(';foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('@foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('#foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('$foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('%foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('^foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('&foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('?foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('!foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('(foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array(')foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('{foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('}foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('[foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array(']foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('§foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('№foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('<foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('>foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array('.foo', $this->sorter()->specialChars()));
        $this->assertFalse(in_array(',foo', $this->sorter()->specialChars()));
    }

    public function testDefaultCallback()
    {
        $callback = $this->sorter()->defaultCallback();

        $this->assertIsCallable($callback);

        $this->assertSame(0, $callback(0, 0));
        $this->assertSame(0, $callback('0', '0'));
        $this->assertSame(0, $callback('foo', 'foo'));

        $this->assertSame(-1, $callback('#', 2));
        $this->assertSame(1, $callback('foo', 2));

        $this->assertSame(1, $callback(2, '#'));
        $this->assertSame(-1, $callback(2, 'foo'));

        $this->assertSame(-1, $callback('a', 'b'));
        $this->assertSame(-1, $callback('foo', 'foz'));
        $this->assertSame(-1, $callback('baz', 'qwe'));

        $this->assertSame(1, $callback('b', 'a'));
        $this->assertSame(1, $callback('foz', 'foo'));
        $this->assertSame(1, $callback('qwe', 'baz'));
    }

    protected function sorter(): Tool
    {
        return new Tool();
    }
}
