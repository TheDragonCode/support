<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Reflection;
use ReflectionClass;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

final class ReflectionTest extends TestCase
{
    public function testResolve()
    {
        $this->assertTrue($this->reflection()->resolve(new ReflectionClass(new Foo())) instanceof ReflectionClass);
        $this->assertTrue($this->reflection()->resolve(new Foo()) instanceof ReflectionClass);
    }

    protected function reflection(): Reflection
    {
        return new Reflection();
    }
}
