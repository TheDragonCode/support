<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

class SpecialCharsIsNotStrictTest extends Base
{
    public function testIsNotStrict()
    {
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
}
