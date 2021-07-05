<?php

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\Reflection;
use ReflectionClass;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ReflectionTest extends TestCase
{
    public function testResolve()
    {
        $this->assertTrue(Reflection::resolve(new ReflectionClass(new Foo())) instanceof ReflectionClass);
        $this->assertTrue(Reflection::resolve(new Foo()) instanceof ReflectionClass);
    }
}
