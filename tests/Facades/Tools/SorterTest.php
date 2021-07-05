<?php

namespace Tests\Facades\Tools;

use Helldar\Support\Facades\Callbacks\Sorter;
use Tests\TestCase;

class SorterTest extends TestCase
{
    public function testSpecialCharsStrict()
    {
        $this->assertIsArray(Sorter::specialChars());

        $this->assertTrue(in_array(' ', Sorter::specialChars(), true));
        $this->assertTrue(in_array('*', Sorter::specialChars(), true));
        $this->assertTrue(in_array('-', Sorter::specialChars(), true));
        $this->assertTrue(in_array('_', Sorter::specialChars(), true));
        $this->assertTrue(in_array('=', Sorter::specialChars(), true));
        $this->assertTrue(in_array('\\', Sorter::specialChars(), true));
        $this->assertTrue(in_array('/', Sorter::specialChars(), true));
        $this->assertTrue(in_array('|', Sorter::specialChars(), true));
        $this->assertTrue(in_array('~', Sorter::specialChars(), true));
        $this->assertTrue(in_array('`', Sorter::specialChars(), true));
        $this->assertTrue(in_array('+', Sorter::specialChars(), true));
        $this->assertTrue(in_array(':', Sorter::specialChars(), true));
        $this->assertTrue(in_array(';', Sorter::specialChars(), true));
        $this->assertTrue(in_array('@', Sorter::specialChars(), true));
        $this->assertTrue(in_array('#', Sorter::specialChars(), true));
        $this->assertTrue(in_array('$', Sorter::specialChars(), true));
        $this->assertTrue(in_array('%', Sorter::specialChars(), true));
        $this->assertTrue(in_array('^', Sorter::specialChars(), true));
        $this->assertTrue(in_array('&', Sorter::specialChars(), true));
        $this->assertTrue(in_array('?', Sorter::specialChars(), true));
        $this->assertTrue(in_array('!', Sorter::specialChars(), true));
        $this->assertTrue(in_array('(', Sorter::specialChars(), true));
        $this->assertTrue(in_array(')', Sorter::specialChars(), true));
        $this->assertTrue(in_array('{', Sorter::specialChars(), true));
        $this->assertTrue(in_array('}', Sorter::specialChars(), true));
        $this->assertTrue(in_array('[', Sorter::specialChars(), true));
        $this->assertTrue(in_array(']', Sorter::specialChars(), true));
        $this->assertTrue(in_array('§', Sorter::specialChars(), true));
        $this->assertTrue(in_array('№', Sorter::specialChars(), true));
        $this->assertTrue(in_array('<', Sorter::specialChars(), true));
        $this->assertTrue(in_array('>', Sorter::specialChars(), true));
        $this->assertTrue(in_array('.', Sorter::specialChars(), true));
        $this->assertTrue(in_array(',', Sorter::specialChars(), true));

        $this->assertFalse(in_array(0, Sorter::specialChars(), true));

        $this->assertFalse(in_array('foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('bar', Sorter::specialChars(), true));
        $this->assertFalse(in_array('baz', Sorter::specialChars(), true));
        $this->assertFalse(in_array('foo bar', Sorter::specialChars(), true));

        $this->assertFalse(in_array(' foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('*foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('-foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('_foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('=foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('\\foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('/foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('|foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('~foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('`foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('+foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array(':foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array(';foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('@foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('#foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('$foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('%foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('^foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('&foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('?foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('!foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('(foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array(')foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('{foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('}foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('[foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array(']foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('§foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('№foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('<foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('>foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array('.foo', Sorter::specialChars(), true));
        $this->assertFalse(in_array(',foo', Sorter::specialChars(), true));
    }

    public function testSpecialChars()
    {
        $this->assertIsArray(Sorter::specialChars());

        $this->assertTrue(in_array(' ', Sorter::specialChars()));
        $this->assertTrue(in_array('*', Sorter::specialChars()));
        $this->assertTrue(in_array('-', Sorter::specialChars()));
        $this->assertTrue(in_array('_', Sorter::specialChars()));
        $this->assertTrue(in_array('=', Sorter::specialChars()));
        $this->assertTrue(in_array('\\', Sorter::specialChars()));
        $this->assertTrue(in_array('/', Sorter::specialChars()));
        $this->assertTrue(in_array('|', Sorter::specialChars()));
        $this->assertTrue(in_array('~', Sorter::specialChars()));
        $this->assertTrue(in_array('`', Sorter::specialChars()));
        $this->assertTrue(in_array('+', Sorter::specialChars()));
        $this->assertTrue(in_array(':', Sorter::specialChars()));
        $this->assertTrue(in_array(';', Sorter::specialChars()));
        $this->assertTrue(in_array('@', Sorter::specialChars()));
        $this->assertTrue(in_array('#', Sorter::specialChars()));
        $this->assertTrue(in_array('$', Sorter::specialChars()));
        $this->assertTrue(in_array('%', Sorter::specialChars()));
        $this->assertTrue(in_array('^', Sorter::specialChars()));
        $this->assertTrue(in_array('&', Sorter::specialChars()));
        $this->assertTrue(in_array('?', Sorter::specialChars()));
        $this->assertTrue(in_array('!', Sorter::specialChars()));
        $this->assertTrue(in_array('(', Sorter::specialChars()));
        $this->assertTrue(in_array(')', Sorter::specialChars()));
        $this->assertTrue(in_array('{', Sorter::specialChars()));
        $this->assertTrue(in_array('}', Sorter::specialChars()));
        $this->assertTrue(in_array('[', Sorter::specialChars()));
        $this->assertTrue(in_array(']', Sorter::specialChars()));
        $this->assertTrue(in_array('§', Sorter::specialChars()));
        $this->assertTrue(in_array('№', Sorter::specialChars()));
        $this->assertTrue(in_array('<', Sorter::specialChars()));
        $this->assertTrue(in_array('>', Sorter::specialChars()));
        $this->assertTrue(in_array('.', Sorter::specialChars()));
        $this->assertTrue(in_array(',', Sorter::specialChars()));

        $this->assertFalse(in_array('foo', Sorter::specialChars()));
        $this->assertFalse(in_array('bar', Sorter::specialChars()));
        $this->assertFalse(in_array('baz', Sorter::specialChars()));
        $this->assertFalse(in_array('foo bar', Sorter::specialChars()));

        $this->assertFalse(in_array(' foo', Sorter::specialChars()));
        $this->assertFalse(in_array('*foo', Sorter::specialChars()));
        $this->assertFalse(in_array('-foo', Sorter::specialChars()));
        $this->assertFalse(in_array('_foo', Sorter::specialChars()));
        $this->assertFalse(in_array('=foo', Sorter::specialChars()));
        $this->assertFalse(in_array('\\foo', Sorter::specialChars()));
        $this->assertFalse(in_array('/foo', Sorter::specialChars()));
        $this->assertFalse(in_array('|foo', Sorter::specialChars()));
        $this->assertFalse(in_array('~foo', Sorter::specialChars()));
        $this->assertFalse(in_array('`foo', Sorter::specialChars()));
        $this->assertFalse(in_array('+foo', Sorter::specialChars()));
        $this->assertFalse(in_array(':foo', Sorter::specialChars()));
        $this->assertFalse(in_array(';foo', Sorter::specialChars()));
        $this->assertFalse(in_array('@foo', Sorter::specialChars()));
        $this->assertFalse(in_array('#foo', Sorter::specialChars()));
        $this->assertFalse(in_array('$foo', Sorter::specialChars()));
        $this->assertFalse(in_array('%foo', Sorter::specialChars()));
        $this->assertFalse(in_array('^foo', Sorter::specialChars()));
        $this->assertFalse(in_array('&foo', Sorter::specialChars()));
        $this->assertFalse(in_array('?foo', Sorter::specialChars()));
        $this->assertFalse(in_array('!foo', Sorter::specialChars()));
        $this->assertFalse(in_array('(foo', Sorter::specialChars()));
        $this->assertFalse(in_array(')foo', Sorter::specialChars()));
        $this->assertFalse(in_array('{foo', Sorter::specialChars()));
        $this->assertFalse(in_array('}foo', Sorter::specialChars()));
        $this->assertFalse(in_array('[foo', Sorter::specialChars()));
        $this->assertFalse(in_array(']foo', Sorter::specialChars()));
        $this->assertFalse(in_array('§foo', Sorter::specialChars()));
        $this->assertFalse(in_array('№foo', Sorter::specialChars()));
        $this->assertFalse(in_array('<foo', Sorter::specialChars()));
        $this->assertFalse(in_array('>foo', Sorter::specialChars()));
        $this->assertFalse(in_array('.foo', Sorter::specialChars()));
        $this->assertFalse(in_array(',foo', Sorter::specialChars()));
    }

    public function testDefaultCallback()
    {
        $callback = Sorter::default();

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
}
