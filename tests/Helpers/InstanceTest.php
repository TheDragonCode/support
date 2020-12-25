<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Instance;
use Tests\Fixtures\Bar;
use Tests\Fixtures\Baz;
use Tests\Fixtures\Contract;
use Tests\Fixtures\Foo;
use Tests\TestCase;

final class InstanceTest extends TestCase
{
    public function testStringOf()
    {
        $class = Foo::class;

        $this->assertFalse(Instance::of($class, Bar::class));
        $this->assertFalse(Instance::of($class, Baz::class));

        $this->assertTrue(Instance::of($class, Contract::class));
        $this->assertTrue(Instance::of($class, Foo::class));

        $this->assertFalse(Instance::of($class, [Bar::class, Baz::class]));
        $this->assertTrue(Instance::of($class, [Bar::class, Baz::class, Contract::class]));
    }

    public function testObjectOf()
    {
        $class = new Foo();

        $this->assertFalse(Instance::of($class, Bar::class));
        $this->assertFalse(Instance::of($class, Baz::class));

        $this->assertTrue(Instance::of($class, Contract::class));
        $this->assertTrue(Instance::of($class, Foo::class));

        $this->assertFalse(Instance::of($class, [Bar::class, Baz::class]));
        $this->assertTrue(Instance::of($class, [Bar::class, Baz::class, Contract::class]));
    }

    public function testBasename()
    {
        $this->assertSame('Foo', Instance::basename(Foo::class));
        $this->assertSame('Bar', Instance::basename(Bar::class));
        $this->assertSame('Baz', Instance::basename(Baz::class));
        $this->assertSame('Contract', Instance::basename(Contract::class));

        $this->assertSame('Foo', Instance::basename(new Foo()));
        $this->assertSame('Bar', Instance::basename(new Bar()));
        $this->assertSame('Baz', Instance::basename(new Baz()));
    }

    public function testClassname()
    {
        $this->assertSame('Tests\Fixtures\Foo', Instance::classname(Foo::class));
        $this->assertSame('Tests\Fixtures\Bar', Instance::classname(Bar::class));
        $this->assertSame('Tests\Fixtures\Baz', Instance::classname(Baz::class));
        $this->assertSame('Tests\Fixtures\Contract', Instance::classname(Contract::class));

        $this->assertSame('Tests\Fixtures\Foo', Instance::classname(new Foo()));
        $this->assertSame('Tests\Fixtures\Bar', Instance::classname(new Bar()));
        $this->assertSame('Tests\Fixtures\Baz', Instance::classname(new Baz()));
    }

    public function testExists()
    {
        $this->assertTrue(Instance::exists(Foo::class));
        $this->assertTrue(Instance::exists(Bar::class));
        $this->assertTrue(Instance::exists(Baz::class));
        $this->assertTrue(Instance::exists(Contract::class));

        $this->assertTrue(Instance::exists(new Foo()));
        $this->assertTrue(Instance::exists(new Bar()));
        $this->assertTrue(Instance::exists(new Baz()));

        $this->assertFalse(Instance::exists('Qwerty'));
    }

    public function testCall()
    {
        $object = new Foo();

        $this->assertNull(Instance::call($object, 'foo'));

        $this->assertSame('ok', Instance::call($object, 'callStatic'));
        $this->assertSame('ok', Instance::call($object, 'callDymamic'));
    }

    public function testCallsWhenNotEmpty()
    {
        $object = new Foo();

        $this->assertNull(Instance::callsWhenNotEmpty($object, 'foo'));
        $this->assertNull(Instance::callsWhenNotEmpty($object, 'callEmpty'));

        $this->assertSame('ok', Instance::callsWhenNotEmpty($object, ['callEmpty', 'callDymamic']));
    }
}
