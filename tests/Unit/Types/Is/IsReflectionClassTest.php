<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Types\Is;

use DragonCode\Support\Facades\Types\Is;
use ReflectionClass;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class IsReflectionClassTest extends TestCase
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
}
