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
        $this->assertTrue($this->boolean()->isTrue('On'));
        $this->assertTrue($this->boolean()->isTrue('ON'));
        $this->assertTrue($this->boolean()->isTrue('yes'));
        $this->assertTrue($this->boolean()->isTrue('Yes'));
        $this->assertTrue($this->boolean()->isTrue('YES'));
        $this->assertTrue($this->boolean()->isTrue('true'));
        $this->assertTrue($this->boolean()->isTrue('True'));
        $this->assertTrue($this->boolean()->isTrue('TRUE'));

        $this->assertFalse($this->boolean()->isTrue(false));
        $this->assertFalse($this->boolean()->isTrue(0));
        $this->assertFalse($this->boolean()->isTrue('0'));
        $this->assertFalse($this->boolean()->isTrue('off'));
        $this->assertFalse($this->boolean()->isTrue('Off'));
        $this->assertFalse($this->boolean()->isTrue('OFF'));
        $this->assertFalse($this->boolean()->isTrue('no'));
        $this->assertFalse($this->boolean()->isTrue('No'));
        $this->assertFalse($this->boolean()->isTrue('NO'));
        $this->assertFalse($this->boolean()->isTrue('false'));
        $this->assertFalse($this->boolean()->isTrue('False'));
        $this->assertFalse($this->boolean()->isTrue('FALSE'));

        $this->assertFalse($this->boolean()->isTrue(null));
        $this->assertFalse($this->boolean()->isTrue('foo'));
        $this->assertFalse($this->boolean()->isTrue('bar'));
        $this->assertFalse($this->boolean()->isTrue('baz'));
        $this->assertFalse($this->boolean()->isTrue([]));
    }

    public function testIsFalse(): void
    {
        $this->assertTrue($this->boolean()->isFalse(null));
        $this->assertTrue($this->boolean()->isFalse(false));
        $this->assertTrue($this->boolean()->isFalse(0));
        $this->assertTrue($this->boolean()->isFalse('0'));
        $this->assertTrue($this->boolean()->isFalse('off'));
        $this->assertTrue($this->boolean()->isFalse('Off'));
        $this->assertTrue($this->boolean()->isFalse('OFF'));
        $this->assertTrue($this->boolean()->isFalse('no'));
        $this->assertTrue($this->boolean()->isFalse('No'));
        $this->assertTrue($this->boolean()->isFalse('NO'));
        $this->assertTrue($this->boolean()->isFalse('false'));
        $this->assertTrue($this->boolean()->isFalse('False'));
        $this->assertTrue($this->boolean()->isFalse('FALSE'));

        $this->assertFalse($this->boolean()->isFalse(true));
        $this->assertFalse($this->boolean()->isFalse(1));
        $this->assertFalse($this->boolean()->isFalse('1'));
        $this->assertFalse($this->boolean()->isFalse('on'));
        $this->assertFalse($this->boolean()->isFalse('On'));
        $this->assertFalse($this->boolean()->isFalse('ON'));
        $this->assertFalse($this->boolean()->isFalse('yes'));
        $this->assertFalse($this->boolean()->isFalse('Yes'));
        $this->assertFalse($this->boolean()->isFalse('YES'));
        $this->assertFalse($this->boolean()->isFalse('true'));
        $this->assertFalse($this->boolean()->isFalse('True'));
        $this->assertFalse($this->boolean()->isFalse('TRUE'));

        $this->assertTrue($this->boolean()->isFalse('foo'));
        $this->assertTrue($this->boolean()->isFalse('bar'));
        $this->assertTrue($this->boolean()->isFalse('baz'));
        $this->assertTrue($this->boolean()->isFalse([]));
    }

    public function testTo(): void
    {
        $this->assertTrue($this->boolean()->to(true));
        $this->assertTrue($this->boolean()->to(1));
        $this->assertTrue($this->boolean()->to('1'));
        $this->assertTrue($this->boolean()->to('on'));
        $this->assertTrue($this->boolean()->to('On'));
        $this->assertTrue($this->boolean()->to('ON'));
        $this->assertTrue($this->boolean()->to('yes'));
        $this->assertTrue($this->boolean()->to('Yes'));
        $this->assertTrue($this->boolean()->to('YES'));
        $this->assertTrue($this->boolean()->to('true'));
        $this->assertTrue($this->boolean()->to('True'));
        $this->assertTrue($this->boolean()->to('TRUE'));

        $this->assertFalse($this->boolean()->to(false));
        $this->assertFalse($this->boolean()->to(0));
        $this->assertFalse($this->boolean()->to('0'));
        $this->assertFalse($this->boolean()->to('off'));
        $this->assertFalse($this->boolean()->to('Off'));
        $this->assertFalse($this->boolean()->to('OFF'));
        $this->assertFalse($this->boolean()->to('no'));
        $this->assertFalse($this->boolean()->to('No'));
        $this->assertFalse($this->boolean()->to('NO'));
        $this->assertFalse($this->boolean()->to('false'));
        $this->assertFalse($this->boolean()->to('False'));
        $this->assertFalse($this->boolean()->to('FALSE'));

        $this->assertFalse($this->boolean()->to('foo'));
        $this->assertFalse($this->boolean()->to('bar'));
        $this->assertFalse($this->boolean()->to('baz'));
        $this->assertFalse($this->boolean()->to([]));
    }

    protected function boolean()
    {
        return new Boolean();
    }
}
