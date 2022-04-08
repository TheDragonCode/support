<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Instances\Helpers;

use DragonCode\Support\Facades\Helpers\Reflection;
use ReflectionClass;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ReflectionTest extends TestCase
{
    public function testResolve()
    {
        $this->assertTrue(Reflection::resolve(new ReflectionClass(new Foo())) instanceof ReflectionClass);
        $this->assertTrue(Reflection::resolve(new Foo()) instanceof ReflectionClass);
    }

    public function testConstants()
    {
        $expected = [
            'FOO' => 'Foo',
            'BAR' => 'Bar',
            'BAZ' => 'Baz',
        ];

        $this->assertSame($expected, Reflection::getConstants(Foo::class));
        $this->assertSame($expected, Reflection::getConstants(new Foo()));
    }

    public function testIsStaticMethod()
    {
        $this->assertTrue(Reflection::isStaticMethod(Foo::class, 'callStatic'));
        $this->assertFalse(Reflection::isStaticMethod(Foo::class, 'callDymamic'));
        $this->assertFalse(Reflection::isStaticMethod(Foo::class, 'callEmpty'));

        $this->assertFalse(Reflection::isStaticMethod(Baq::class, 'toArray'));
    }
}
