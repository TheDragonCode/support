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

namespace Tests\Helpers;

use DragonCode\Support\Helpers\Reflection;
use ReflectionClass;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ReflectionTest extends TestCase
{
    public function testResolve()
    {
        $this->assertTrue($this->reflection()->resolve(new ReflectionClass(new Foo())) instanceof ReflectionClass);
        $this->assertTrue($this->reflection()->resolve(new Foo()) instanceof ReflectionClass);
    }

    public function testConstants()
    {
        $expected = [
            'FOO' => 'Foo',
            'BAR' => 'Bar',
            'BAZ' => 'Baz',
        ];

        $this->assertSame($expected, $this->reflection()->getConstants(Foo::class));
        $this->assertSame($expected, $this->reflection()->getConstants(new Foo()));
    }

    public function testIsStaticMethod()
    {
        $this->assertTrue($this->reflection()->isStaticMethod(Foo::class, 'callStatic'));
        $this->assertFalse($this->reflection()->isStaticMethod(Foo::class, 'callDymamic'));
        $this->assertFalse($this->reflection()->isStaticMethod(Foo::class, 'callEmpty'));

        $this->assertFalse($this->reflection()->isStaticMethod(Baq::class, 'toArray'));
    }

    protected function reflection(): Reflection
    {
        return new Reflection();
    }
}
