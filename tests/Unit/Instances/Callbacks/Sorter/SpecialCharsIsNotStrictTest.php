<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

use DragonCode\Support\Facades\Callbacks\Sorter;

class SpecialCharsIsNotStrictTest extends Base
{
    public function testIsNotStrict()
    {
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
}
