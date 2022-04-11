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

namespace Tests\Unit\Instances\Reflection;

use DragonCode\Support\Facades\Instances\Reflection;
use ReflectionClass;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ResolveTest extends TestCase
{
    public function testResolve()
    {
        $this->assertTrue(Reflection::resolve(new ReflectionClass(new Foo())) instanceof ReflectionClass);
        $this->assertTrue(Reflection::resolve(new Foo()) instanceof ReflectionClass);
    }
}
