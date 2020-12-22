<?php

namespace Tests\Helpers;

use Helldar\Support\Services\Reflection;
use ReflectionClass;
use Tests\Fixtures\Foo;
use Tests\TestCase;

final class ReflectionTest extends TestCase
{
    public function testResolve()
    {
        $this->assertTrue(
            Reflection::resolve(Foo::class) instanceof ReflectionClass
        );

        $this->assertTrue(
            Reflection::resolve(new Foo()) instanceof ReflectionClass
        );
    }
}
