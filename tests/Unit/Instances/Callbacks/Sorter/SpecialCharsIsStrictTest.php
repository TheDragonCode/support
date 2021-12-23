<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

class SpecialCharsIsStrictTest extends Base
{
    public function testStrict()
    {
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
}
