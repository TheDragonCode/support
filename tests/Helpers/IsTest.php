<?php

namespace Tests\Helpers;

use Helldar\Support\Facades\Is;
use ReflectionClass;
use Tests\Fixtures\Bar;
use Tests\Fixtures\Baz;
use Tests\Fixtures\Contract;
use Tests\Fixtures\Foo;
use Tests\TestCase;

final class IsTest extends TestCase
{
    public function testObject()
    {
        $this->assertTrue(Is::object(new Foo()));
        $this->assertFalse(Is::object(Foo::class));
    }

    public function testString()
    {
        $this->assertFalse(Is::string(new Foo()));
        $this->assertTrue(Is::string(Foo::class));
    }

    public function testContract()
    {
        $this->assertFalse(Is::contract(new Foo()));
        $this->assertFalse(Is::contract(Foo::class));

        $this->assertFalse(Is::contract(new Bar()));
        $this->assertFalse(Is::contract(Bar::class));

        $this->assertFalse(Is::contract(new Baz()));
        $this->assertFalse(Is::contract(Baz::class));

        $this->assertTrue(Is::contract(Contract::class));
    }

    public function testReflectionClass()
    {
        $this->assertFalse(Is::reflectionClass(new Foo()));
        $this->assertFalse(Is::reflectionClass(Foo::class));

        $this->assertFalse(Is::reflectionClass(new Bar()));
        $this->assertFalse(Is::reflectionClass(Bar::class));

        $this->assertFalse(Is::reflectionClass(new Baz()));
        $this->assertFalse(Is::reflectionClass(Baz::class));

        $this->assertFalse(Is::reflectionClass(Contract::class));

        $this->assertTrue(Is::reflectionClass(new ReflectionClass(new Foo())));
    }
}
