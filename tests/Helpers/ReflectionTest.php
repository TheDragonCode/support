<?php
/*
 * This file is part of the "andrey-helldar/support" project.
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
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Helpers;

use Helldar\Support\Helpers\Reflection;
use ReflectionClass;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ReflectionTest extends TestCase
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
