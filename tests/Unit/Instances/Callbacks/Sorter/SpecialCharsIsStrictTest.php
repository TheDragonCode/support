<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

use DragonCode\Support\Facades\Callbacks\Sorter;

class SpecialCharsIsStrictTest extends Base
{
    public function testStrict()
    {
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
}
