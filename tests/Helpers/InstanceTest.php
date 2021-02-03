<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Instance;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class InstanceTest extends TestCase
{
    public function testOf()
    {
        // Foo
        $this->assertTrue($this->instance()->of(Foo::class, Foo::class));
        $this->assertFalse($this->instance()->of(Foo::class, Bar::class));
        $this->assertTrue($this->instance()->of(Foo::class, Contract::class));

        $this->assertTrue($this->instance()->of(new Foo(), Foo::class));
        $this->assertFalse($this->instance()->of(new Foo(), Bar::class));
        $this->assertTrue($this->instance()->of(new Foo(), Contract::class));

        // Bar
        $this->assertTrue($this->instance()->of(Bar::class, Bar::class));
        $this->assertFalse($this->instance()->of(Bar::class, Foo::class));
        $this->assertFalse($this->instance()->of(Bar::class, Contract::class));

        $this->assertTrue($this->instance()->of(new Bar(), Bar::class));
        $this->assertFalse($this->instance()->of(new Bar(), Foo::class));
        $this->assertFalse($this->instance()->of(new Bar(), Contract::class));
    }

    public function testClassname()
    {
        $this->assertSame('Tests\Fixtures\Instances\Foo', $this->instance()->classname(Foo::class));
        $this->assertSame('Tests\Fixtures\Instances\Bar', $this->instance()->classname(Bar::class));
        $this->assertSame('Tests\Fixtures\Instances\Baz', $this->instance()->classname(Baz::class));

        $this->assertSame('Tests\Fixtures\Instances\Foo', $this->instance()->classname(new Foo()));
        $this->assertSame('Tests\Fixtures\Instances\Bar', $this->instance()->classname(new Bar()));
        $this->assertSame('Tests\Fixtures\Instances\Baz', $this->instance()->classname(new Baz()));

        $this->assertSame('Tests\Fixtures\Contracts\Contract', $this->instance()->classname(Contract::class));

        $this->assertNull($this->instance()->classname('foo'));
    }

    public function testBasename()
    {
        $this->assertSame('Foo', $this->instance()->basename(Foo::class));
        $this->assertSame('Bar', $this->instance()->basename(Bar::class));
        $this->assertSame('Baz', $this->instance()->basename(Baz::class));

        $this->assertSame('Foo', $this->instance()->basename(new Foo()));
        $this->assertSame('Bar', $this->instance()->basename(new Bar()));
        $this->assertSame('Baz', $this->instance()->basename(new Baz()));

        $this->assertNull($this->instance()->basename('foo'));
    }

    /** @deprecated */
    public function testCall()
    {
        $this->assertSame('ok', $this->instance()->call(new Foo(), 'callDymamic'));
        $this->assertSame('foo', $this->instance()->call(new Foo(), 'unknown', 'foo'));
        $this->assertSame('foo', $this->instance()->call(Foo::class, 'unknown', 'foo'));

        $this->assertNull($this->instance()->call(Foo::class, 'unknown'));
    }

    /** @deprecated */
    public function testCallOf()
    {
        $this->assertSame('ok', $this->instance()->callOf([
            Contract::class => 'callDymamic',
        ], new Foo()));

        $this->assertSame('ok', $this->instance()->callOf([
            'Unknown'       => 'unknown',
            Contract::class => 'callDymamic',
        ], new Foo()));

        $this->assertSame('foo', $this->instance()->callOf([
            'Unknown' => 'unknown',
        ], new Foo(), 'foo'));

        $this->assertNull($this->instance()->callOf([
            'Unknown' => 'unknown',
        ], new Foo()));

        $this->assertNull($this->instance()->callOf([
            'Unknown' => 'unknown',
        ], 'foo'));
    }

    /** @deprecated */
    public function testCallsWhenNotEmpty()
    {
        $this->assertSame('ok', $this->instance()->callWhen(new Foo(), 'callDymamic'));
        $this->assertSame('ok', $this->instance()->callWhen(new Foo(), ['unknown', 'callDymamic']));
        $this->assertSame('foo', $this->instance()->callWhen(new Foo(), 'unknown', 'foo'));
        $this->assertSame('foo', $this->instance()->callWhen(Foo::class, 'unknown', 'foo'));

        $this->assertNull($this->instance()->callWhen(Foo::class, 'unknown'));
    }

    public function testExists()
    {
        $this->assertTrue($this->instance()->exists(new Foo()));
        $this->assertTrue($this->instance()->exists(new Bar()));
        $this->assertTrue($this->instance()->exists(new Baz()));

        $this->assertTrue($this->instance()->exists(Foo::class));
        $this->assertTrue($this->instance()->exists(Bar::class));
        $this->assertTrue($this->instance()->exists(Baz::class));

        $this->assertTrue($this->instance()->exists(Contract::class));

        $this->assertFalse($this->instance()->exists('foo'));
    }

    protected function instance(): Instance
    {
        return new Instance();
    }
}
