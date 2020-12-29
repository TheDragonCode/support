<?php

namespace Tests\Helpers;

use Exception;
use Helldar\Support\Helpers\Is;
use ReflectionClass;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class IsTest extends TestCase
{
    public function testReflectionClass()
    {
        $this->assertTrue($this->is()->reflectionClass(new ReflectionClass(new Foo())));
        $this->assertTrue($this->is()->reflectionClass(new ReflectionClass(new Bar())));
        $this->assertTrue($this->is()->reflectionClass(new ReflectionClass(new Baz())));

        $this->assertFalse($this->is()->reflectionClass(new Foo()));
        $this->assertFalse($this->is()->reflectionClass(new Bar()));
        $this->assertFalse($this->is()->reflectionClass(new Baz()));

        $this->assertFalse($this->is()->reflectionClass(Foo::class));
        $this->assertFalse($this->is()->reflectionClass(Bar::class));
        $this->assertFalse($this->is()->reflectionClass(Baz::class));

        $this->assertFalse($this->is()->reflectionClass('foo'));
    }

    public function testError()
    {
        $this->assertTrue($this->is()->error(new Exception()));

        $this->assertFalse($this->is()->error(new Foo()));
        $this->assertFalse($this->is()->error(new Bar()));
        $this->assertFalse($this->is()->error(new Baz()));

        $this->assertFalse($this->is()->error('foo'));
    }

    public function testContract()
    {
        $this->assertTrue($this->is()->contract(Contract::class));

        $this->assertFalse($this->is()->contract(Foo::class));
        $this->assertFalse($this->is()->contract(Bar::class));
        $this->assertFalse($this->is()->contract(Baz::class));

        $this->assertFalse($this->is()->contract(new Foo()));
        $this->assertFalse($this->is()->contract(new Bar()));
        $this->assertFalse($this->is()->contract(new Baz()));

        $this->assertFalse($this->is()->contract('foo'));
    }

    public function testString()
    {
        $this->assertTrue($this->is()->string('foo'));
        $this->assertTrue($this->is()->string('bar'));
        $this->assertTrue($this->is()->string('baz'));

        $this->assertTrue($this->is()->string(Foo::class));
        $this->assertTrue($this->is()->string(Bar::class));
        $this->assertTrue($this->is()->string(Baz::class));

        $this->assertFalse($this->is()->string(new Foo()));
        $this->assertFalse($this->is()->string(new Bar()));
        $this->assertFalse($this->is()->string(new Baz()));
    }

    public function testObject()
    {
        $this->assertFalse($this->is()->object('foo'));
        $this->assertFalse($this->is()->object('bar'));
        $this->assertFalse($this->is()->object('baz'));

        $this->assertFalse($this->is()->object(Foo::class));
        $this->assertFalse($this->is()->object(Bar::class));
        $this->assertFalse($this->is()->object(Baz::class));

        $this->assertTrue($this->is()->object(new Foo()));
        $this->assertTrue($this->is()->object(new Bar()));
        $this->assertTrue($this->is()->object(new Baz()));
    }

    protected function is(): Is
    {
        return new Is();
    }
}
