<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\Boolean;
use Tests\TestCase;

class BooleanTest extends TestCase
{
    public function testIsTrue(): void
    {
        $this->assertTrue(Boolean::isTrue(true));
        $this->assertTrue(Boolean::isTrue(1));
        $this->assertTrue(Boolean::isTrue('1'));
        $this->assertTrue(Boolean::isTrue('on'));
        $this->assertTrue(Boolean::isTrue('On'));
        $this->assertTrue(Boolean::isTrue('ON'));
        $this->assertTrue(Boolean::isTrue('yes'));
        $this->assertTrue(Boolean::isTrue('Yes'));
        $this->assertTrue(Boolean::isTrue('YES'));
        $this->assertTrue(Boolean::isTrue('true'));
        $this->assertTrue(Boolean::isTrue('True'));
        $this->assertTrue(Boolean::isTrue('TRUE'));

        $this->assertFalse(Boolean::isTrue(false));
        $this->assertFalse(Boolean::isTrue(0));
        $this->assertFalse(Boolean::isTrue('0'));
        $this->assertFalse(Boolean::isTrue('off'));
        $this->assertFalse(Boolean::isTrue('Off'));
        $this->assertFalse(Boolean::isTrue('OFF'));
        $this->assertFalse(Boolean::isTrue('no'));
        $this->assertFalse(Boolean::isTrue('No'));
        $this->assertFalse(Boolean::isTrue('NO'));
        $this->assertFalse(Boolean::isTrue('false'));
        $this->assertFalse(Boolean::isTrue('False'));
        $this->assertFalse(Boolean::isTrue('FALSE'));

        $this->assertFalse(Boolean::isTrue(null));
        $this->assertFalse(Boolean::isTrue(' '));
        $this->assertFalse(Boolean::isTrue('foo'));
        $this->assertFalse(Boolean::isTrue('bar'));
        $this->assertFalse(Boolean::isTrue('baz'));
        $this->assertFalse(Boolean::isTrue([]));
        $this->assertFalse(Boolean::isTrue(['foo', 'bar']));
    }

    public function testIsFalse(): void
    {
        $this->assertTrue(Boolean::isFalse(null));
        $this->assertTrue(Boolean::isFalse(false));
        $this->assertTrue(Boolean::isFalse(0));
        $this->assertTrue(Boolean::isFalse('0'));
        $this->assertTrue(Boolean::isFalse('off'));
        $this->assertTrue(Boolean::isFalse('Off'));
        $this->assertTrue(Boolean::isFalse('OFF'));
        $this->assertTrue(Boolean::isFalse('no'));
        $this->assertTrue(Boolean::isFalse('No'));
        $this->assertTrue(Boolean::isFalse('NO'));
        $this->assertTrue(Boolean::isFalse('false'));
        $this->assertTrue(Boolean::isFalse('False'));
        $this->assertTrue(Boolean::isFalse('FALSE'));

        $this->assertFalse(Boolean::isFalse(true));
        $this->assertFalse(Boolean::isFalse(1));
        $this->assertFalse(Boolean::isFalse('1'));
        $this->assertFalse(Boolean::isFalse('on'));
        $this->assertFalse(Boolean::isFalse('On'));
        $this->assertFalse(Boolean::isFalse('ON'));
        $this->assertFalse(Boolean::isFalse('yes'));
        $this->assertFalse(Boolean::isFalse('Yes'));
        $this->assertFalse(Boolean::isFalse('YES'));
        $this->assertFalse(Boolean::isFalse('true'));
        $this->assertFalse(Boolean::isFalse('True'));
        $this->assertFalse(Boolean::isFalse('TRUE'));

        $this->assertTrue(Boolean::isFalse(' '));
        $this->assertTrue(Boolean::isFalse('foo'));
        $this->assertTrue(Boolean::isFalse('bar'));
        $this->assertTrue(Boolean::isFalse('baz'));
        $this->assertTrue(Boolean::isFalse([]));
        $this->assertTrue(Boolean::isFalse(['foo', 'bar']));
    }

    public function testTo(): void
    {
        $this->assertTrue(Boolean::to(true));
        $this->assertTrue(Boolean::to(1));
        $this->assertTrue(Boolean::to('1'));
        $this->assertTrue(Boolean::to('on'));
        $this->assertTrue(Boolean::to('On'));
        $this->assertTrue(Boolean::to('ON'));
        $this->assertTrue(Boolean::to('yes'));
        $this->assertTrue(Boolean::to('Yes'));
        $this->assertTrue(Boolean::to('YES'));
        $this->assertTrue(Boolean::to('true'));
        $this->assertTrue(Boolean::to('True'));
        $this->assertTrue(Boolean::to('TRUE'));

        $this->assertFalse(Boolean::to(false));
        $this->assertFalse(Boolean::to(0));
        $this->assertFalse(Boolean::to('0'));
        $this->assertFalse(Boolean::to('off'));
        $this->assertFalse(Boolean::to('Off'));
        $this->assertFalse(Boolean::to('OFF'));
        $this->assertFalse(Boolean::to('no'));
        $this->assertFalse(Boolean::to('No'));
        $this->assertFalse(Boolean::to('NO'));
        $this->assertFalse(Boolean::to('false'));
        $this->assertFalse(Boolean::to('False'));
        $this->assertFalse(Boolean::to('FALSE'));

        $this->assertFalse(Boolean::to(' '));
        $this->assertFalse(Boolean::to('foo'));
        $this->assertFalse(Boolean::to('bar'));
        $this->assertFalse(Boolean::to('baz'));
        $this->assertFalse(Boolean::to([]));
        $this->assertFalse(Boolean::to(['foo', 'bar']));
    }

    public function testParse(): void
    {
        $this->assertTrue(Boolean::parse(true));
        $this->assertTrue(Boolean::parse(1));
        $this->assertTrue(Boolean::parse('1'));
        $this->assertTrue(Boolean::parse('on'));
        $this->assertTrue(Boolean::parse('On'));
        $this->assertTrue(Boolean::parse('ON'));
        $this->assertTrue(Boolean::parse('yes'));
        $this->assertTrue(Boolean::parse('Yes'));
        $this->assertTrue(Boolean::parse('YES'));
        $this->assertTrue(Boolean::parse('true'));
        $this->assertTrue(Boolean::parse('True'));
        $this->assertTrue(Boolean::parse('TRUE'));

        $this->assertFalse(Boolean::parse(' '));
        $this->assertFalse(Boolean::parse(false));
        $this->assertFalse(Boolean::parse(0));
        $this->assertFalse(Boolean::parse('0'));
        $this->assertFalse(Boolean::parse('off'));
        $this->assertFalse(Boolean::parse('Off'));
        $this->assertFalse(Boolean::parse('OFF'));
        $this->assertFalse(Boolean::parse('no'));
        $this->assertFalse(Boolean::parse('No'));
        $this->assertFalse(Boolean::parse('NO'));
        $this->assertFalse(Boolean::parse('false'));
        $this->assertFalse(Boolean::parse('False'));
        $this->assertFalse(Boolean::parse('FALSE'));

        $this->assertNull(Boolean::parse('foo'));
        $this->assertNull(Boolean::parse('bar'));
        $this->assertNull(Boolean::parse('baz'));
        $this->assertNull(Boolean::parse([]));
        $this->assertNull(Boolean::parse(['foo', 'bar']));
    }

    public function testConvertToString()
    {
        $this->assertSame('true', Boolean::convertToString(true));
        $this->assertSame('true', Boolean::convertToString(1));

        $this->assertSame('false', Boolean::convertToString(false));
        $this->assertSame('false', Boolean::convertToString(0));
    }
}
