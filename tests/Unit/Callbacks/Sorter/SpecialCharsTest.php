<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Callbacks\Sorter;

use DragonCode\Support\Facades\Callbacks\Sorter;
use Tests\TestCase;

class SpecialCharsTest extends TestCase
{
    public function testIsArrayValue()
    {
        $this->assertIsArray(Sorter::specialChars());
    }

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
