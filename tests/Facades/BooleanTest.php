<?php

namespace Tests\Facades;

use Helldar\Support\Facades\Helpers\Boolean;
use Tests\TestCase;

final class BooleanTest extends TestCase
{
    public function testIsTrue(): void
    {
        $this->assertTrue(Boolean::isTrue(true));
        $this->assertTrue(Boolean::isTrue(1));
        $this->assertTrue(Boolean::isTrue('1'));
        $this->assertTrue(Boolean::isTrue('on'));
        $this->assertTrue(Boolean::isTrue('true'));

        $this->assertFalse(Boolean::isTrue(null));
        $this->assertFalse(Boolean::isTrue(false));
        $this->assertFalse(Boolean::isTrue(0));
        $this->assertFalse(Boolean::isTrue('0'));
        $this->assertFalse(Boolean::isTrue('off'));
        $this->assertFalse(Boolean::isTrue('false'));
        $this->assertFalse(Boolean::isTrue('foo'));
        $this->assertFalse(Boolean::isTrue('bar'));
        $this->assertFalse(Boolean::isTrue('baz'));
        $this->assertFalse(Boolean::isTrue([]));
    }

    public function testIsFalse(): void
    {
        $this->assertTrue(Boolean::isFalse(false));
        $this->assertTrue(Boolean::isFalse(0));
        $this->assertTrue(Boolean::isFalse('0'));
        $this->assertTrue(Boolean::isFalse('off'));
        $this->assertTrue(Boolean::isFalse('false'));

        $this->assertFalse(Boolean::isFalse(null));
        $this->assertFalse(Boolean::isFalse(true));
        $this->assertFalse(Boolean::isFalse(1));
        $this->assertFalse(Boolean::isFalse('1'));
        $this->assertFalse(Boolean::isFalse('on'));
        $this->assertFalse(Boolean::isFalse('true'));
        $this->assertFalse(Boolean::isFalse('foo'));
        $this->assertFalse(Boolean::isFalse('bar'));
        $this->assertFalse(Boolean::isFalse('baz'));
        $this->assertFalse(Boolean::isFalse([]));
    }

    public function testTo(): void
    {
        $this->assertTrue(Boolean::to(true));
        $this->assertTrue(Boolean::to(1));
        $this->assertTrue(Boolean::to('1'));
        $this->assertTrue(Boolean::to('on'));
        $this->assertTrue(Boolean::to('true'));
        $this->assertTrue(Boolean::to('foo'));
        $this->assertTrue(Boolean::to('bar'));
        $this->assertTrue(Boolean::to('baz'));
        $this->assertTrue(Boolean::to('qwerty'));
        $this->assertTrue(Boolean::to('[]'));
        $this->assertTrue(Boolean::to(['foo']));
        $this->assertTrue(Boolean::to(['foo', 'bar']));

        $this->assertFalse(Boolean::to(null));
        $this->assertFalse(Boolean::to(false));
        $this->assertFalse(Boolean::to(0));
        $this->assertFalse(Boolean::to('0'));
        $this->assertFalse(Boolean::to('off'));
        $this->assertFalse(Boolean::to('false'));
        $this->assertFalse(Boolean::to([]));
    }
}
