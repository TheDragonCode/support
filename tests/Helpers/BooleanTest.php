<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Boolean;
use Tests\TestCase;

final class BooleanTest extends TestCase
{
    public function testIsTrue(): void
    {
        $this->assertTrue($this->boolean()->isTrue(true));
        $this->assertTrue($this->boolean()->isTrue(1));
        $this->assertTrue($this->boolean()->isTrue('1'));
        $this->assertTrue($this->boolean()->isTrue('on'));
        $this->assertTrue($this->boolean()->isTrue('true'));

        $this->assertFalse($this->boolean()->isTrue(null));
        $this->assertFalse($this->boolean()->isTrue(false));
        $this->assertFalse($this->boolean()->isTrue(0));
        $this->assertFalse($this->boolean()->isTrue('0'));
        $this->assertFalse($this->boolean()->isTrue('off'));
        $this->assertFalse($this->boolean()->isTrue('false'));
        $this->assertFalse($this->boolean()->isTrue('foo'));
        $this->assertFalse($this->boolean()->isTrue('bar'));
        $this->assertFalse($this->boolean()->isTrue('baz'));
        $this->assertFalse($this->boolean()->isTrue([]));
    }

    public function testIsFalse(): void
    {
        $this->assertTrue($this->boolean()->isFalse(false));
        $this->assertTrue($this->boolean()->isFalse(0));
        $this->assertTrue($this->boolean()->isFalse('0'));
        $this->assertTrue($this->boolean()->isFalse('off'));
        $this->assertTrue($this->boolean()->isFalse('false'));

        $this->assertFalse($this->boolean()->isFalse(null));
        $this->assertFalse($this->boolean()->isFalse(true));
        $this->assertFalse($this->boolean()->isFalse(1));
        $this->assertFalse($this->boolean()->isFalse('1'));
        $this->assertFalse($this->boolean()->isFalse('on'));
        $this->assertFalse($this->boolean()->isFalse('true'));
        $this->assertFalse($this->boolean()->isFalse('foo'));
        $this->assertFalse($this->boolean()->isFalse('bar'));
        $this->assertFalse($this->boolean()->isFalse('baz'));
        $this->assertFalse($this->boolean()->isFalse([]));
    }

    public function testTo(): void
    {
        $this->assertTrue($this->boolean()->to(true));
        $this->assertTrue($this->boolean()->to(1));
        $this->assertTrue($this->boolean()->to('1'));
        $this->assertTrue($this->boolean()->to('on'));
        $this->assertTrue($this->boolean()->to('true'));
        $this->assertTrue($this->boolean()->to('foo'));
        $this->assertTrue($this->boolean()->to('bar'));
        $this->assertTrue($this->boolean()->to('baz'));
        $this->assertTrue($this->boolean()->to('qwerty'));
        $this->assertTrue($this->boolean()->to('[]'));
        $this->assertTrue($this->boolean()->to(['foo']));
        $this->assertTrue($this->boolean()->to(['foo', 'bar']));

        $this->assertFalse($this->boolean()->to(null));
        $this->assertFalse($this->boolean()->to(false));
        $this->assertFalse($this->boolean()->to(0));
        $this->assertFalse($this->boolean()->to('0'));
        $this->assertFalse($this->boolean()->to('off'));
        $this->assertFalse($this->boolean()->to('false'));
        $this->assertFalse($this->boolean()->to([]));
    }

    protected function boolean()
    {
        return new Boolean();
    }
}
