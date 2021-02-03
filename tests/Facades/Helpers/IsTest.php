<?php

namespace Tests\Facades\Helpers;

use Exception;
use Helldar\Support\Facades\Helpers\Is;
use ReflectionClass;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class IsTest extends TestCase
{
    public function testReflectionClass()
    {
        $this->assertTrue(Is::reflectionClass(new ReflectionClass(new Foo())));
        $this->assertTrue(Is::reflectionClass(new ReflectionClass(new Bar())));
        $this->assertTrue(Is::reflectionClass(new ReflectionClass(new Baz())));

        $this->assertFalse(Is::reflectionClass(new Foo()));
        $this->assertFalse(Is::reflectionClass(new Bar()));
        $this->assertFalse(Is::reflectionClass(new Baz()));

        $this->assertFalse(Is::reflectionClass(Foo::class));
        $this->assertFalse(Is::reflectionClass(Bar::class));
        $this->assertFalse(Is::reflectionClass(Baz::class));

        $this->assertFalse(Is::reflectionClass('foo'));
    }

    public function testError()
    {
        $this->assertTrue(Is::error(new Exception()));

        $this->assertFalse(Is::error(new Foo()));
        $this->assertFalse(Is::error(new Bar()));
        $this->assertFalse(Is::error(new Baz()));

        $this->assertFalse(Is::error('foo'));
    }

    public function testContract()
    {
        $this->assertTrue(Is::contract(Contract::class));

        $this->assertFalse(Is::contract(Foo::class));
        $this->assertFalse(Is::contract(Bar::class));
        $this->assertFalse(Is::contract(Baz::class));

        $this->assertFalse(Is::contract(new Foo()));
        $this->assertFalse(Is::contract(new Bar()));
        $this->assertFalse(Is::contract(new Baz()));

        $this->assertFalse(Is::contract('foo'));
    }

    public function testString()
    {
        $this->assertTrue(Is::string('foo'));
        $this->assertTrue(Is::string('bar'));
        $this->assertTrue(Is::string('baz'));

        $this->assertTrue(Is::string(Foo::class));
        $this->assertTrue(Is::string(Bar::class));
        $this->assertTrue(Is::string(Baz::class));

        $this->assertFalse(Is::string(new Foo()));
        $this->assertFalse(Is::string(new Bar()));
        $this->assertFalse(Is::string(new Baz()));
    }

    public function testObject()
    {
        $this->assertFalse(Is::object('foo'));
        $this->assertFalse(Is::object('bar'));
        $this->assertFalse(Is::object('baz'));

        $this->assertFalse(Is::object(Foo::class));
        $this->assertFalse(Is::object(Bar::class));
        $this->assertFalse(Is::object(Baz::class));

        $this->assertTrue(Is::object(new Foo()));
        $this->assertTrue(Is::object(new Bar()));
        $this->assertTrue(Is::object(new Baz()));
    }

    public function testIsEmpty()
    {
        $this->assertTrue(Is::isEmpty(''));
        $this->assertTrue(Is::isEmpty(' '));
        $this->assertTrue(Is::isEmpty('      '));
        $this->assertTrue(Is::isEmpty(null));

        $this->assertFalse(Is::isEmpty(0));
        $this->assertFalse(Is::isEmpty('   0   '));
        $this->assertFalse(Is::isEmpty(false));

        $this->assertTrue(Is::isEmpty([]));
        $this->assertTrue(Is::isEmpty(new Foo()));

        $this->assertFalse(Is::isEmpty(new Bar()));
        $this->assertFalse(Is::isEmpty(new Baz()));
        $this->assertFalse(Is::isEmpty(new Baq()));
        $this->assertFalse(Is::isEmpty(new Arrayable()));
    }
}
