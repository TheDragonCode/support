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

namespace Tests\Unit\Helpers;

use DragonCode\Support\Helpers\Is;
use Exception;
use ReflectionClass;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Arrayable;
use Tests\Fixtures\Instances\Baq;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class IsTest extends TestCase
{
    public function testReflectionClass()
    {
        $this->assertTrue($this->is()->reflectionClass(new ReflectionClass(new Foo())));
        $this->assertTrue($this->is()->reflectionClass(new ReflectionClass(new Bar())));
        $this->assertTrue($this->is()->reflectionClass(new ReflectionClass(new Baz())));

        $this->assertFalse($this->is()->reflectionClass(new Foo()));
        $this->assertFalse($this->is()->reflectionClass(new Bar()));
        $this->assertFalse($this->is()->reflectionClass(new Baz()));

        $this->assertFalse($this->is()->reflectionClass(Foo::class));
        $this->assertFalse($this->is()->reflectionClass(Bar::class));
        $this->assertFalse($this->is()->reflectionClass(Baz::class));

        $this->assertFalse($this->is()->reflectionClass('foo'));
    }

    public function testError()
    {
        $this->assertTrue($this->is()->error(new Exception()));

        $this->assertFalse($this->is()->error(new Foo()));
        $this->assertFalse($this->is()->error(new Bar()));
        $this->assertFalse($this->is()->error(new Baz()));

        $this->assertFalse($this->is()->error('foo'));
    }

    public function testContract()
    {
        $this->assertTrue($this->is()->contract(Contract::class));

        $this->assertFalse($this->is()->contract(Foo::class));
        $this->assertFalse($this->is()->contract(Bar::class));
        $this->assertFalse($this->is()->contract(Baz::class));

        $this->assertFalse($this->is()->contract(new Foo()));
        $this->assertFalse($this->is()->contract(new Bar()));
        $this->assertFalse($this->is()->contract(new Baz()));

        $this->assertFalse($this->is()->contract('foo'));
    }

    public function testString()
    {
        $this->assertTrue($this->is()->string('foo'));
        $this->assertTrue($this->is()->string('bar'));
        $this->assertTrue($this->is()->string('baz'));

        $this->assertTrue($this->is()->string(Foo::class));
        $this->assertTrue($this->is()->string(Bar::class));
        $this->assertTrue($this->is()->string(Baz::class));

        $this->assertFalse($this->is()->string(new Foo()));
        $this->assertFalse($this->is()->string(new Bar()));
        $this->assertFalse($this->is()->string(new Baz()));
    }

    public function testObject()
    {
        $this->assertFalse($this->is()->object('foo'));
        $this->assertFalse($this->is()->object('bar'));
        $this->assertFalse($this->is()->object('baz'));

        $this->assertFalse($this->is()->object(Foo::class));
        $this->assertFalse($this->is()->object(Bar::class));
        $this->assertFalse($this->is()->object(Baz::class));

        $this->assertTrue($this->is()->object(new Foo()));
        $this->assertTrue($this->is()->object(new Bar()));
        $this->assertTrue($this->is()->object(new Baz()));
    }

    public function testIsBoolean()
    {
        $this->assertTrue($this->is()->boolean(true));
        $this->assertTrue($this->is()->boolean(1));
        $this->assertTrue($this->is()->boolean('1'));
        $this->assertTrue($this->is()->boolean('on'));
        $this->assertTrue($this->is()->boolean('On'));
        $this->assertTrue($this->is()->boolean('ON'));
        $this->assertTrue($this->is()->boolean('yes'));
        $this->assertTrue($this->is()->boolean('Yes'));
        $this->assertTrue($this->is()->boolean('YES'));
        $this->assertTrue($this->is()->boolean('true'));
        $this->assertTrue($this->is()->boolean('True'));
        $this->assertTrue($this->is()->boolean('TRUE'));

        $this->assertTrue($this->is()->boolean(false));
        $this->assertTrue($this->is()->boolean(0));
        $this->assertTrue($this->is()->boolean('0'));
        $this->assertTrue($this->is()->boolean('off'));
        $this->assertTrue($this->is()->boolean('Off'));
        $this->assertTrue($this->is()->boolean('OFF'));
        $this->assertTrue($this->is()->boolean('no'));
        $this->assertTrue($this->is()->boolean('No'));
        $this->assertTrue($this->is()->boolean('NO'));
        $this->assertTrue($this->is()->boolean('false'));
        $this->assertTrue($this->is()->boolean('False'));
        $this->assertTrue($this->is()->boolean('FALSE'));

        $this->assertFalse($this->is()->boolean(null));
        $this->assertFalse($this->is()->boolean('foo'));
        $this->assertFalse($this->is()->boolean('bar'));
        $this->assertFalse($this->is()->boolean('baz'));
        $this->assertFalse($this->is()->boolean('qwerty'));
        $this->assertFalse($this->is()->boolean(['foo']));
        $this->assertFalse($this->is()->boolean(['foo', 'bar']));
        $this->assertFalse($this->is()->boolean([]));
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->is()->isEmpty(''));
        $this->assertTrue($this->is()->isEmpty(' '));
        $this->assertTrue($this->is()->isEmpty('      '));
        $this->assertTrue($this->is()->isEmpty(null));

        $this->assertFalse($this->is()->isEmpty(0));
        $this->assertFalse($this->is()->isEmpty('   0   '));
        $this->assertFalse($this->is()->isEmpty(false));

        $this->assertTrue($this->is()->isEmpty([]));
        $this->assertTrue($this->is()->isEmpty(new Foo()));

        $this->assertFalse($this->is()->isEmpty(new Bar()));
        $this->assertFalse($this->is()->isEmpty(new Baz()));
        $this->assertFalse($this->is()->isEmpty(new Baq()));
        $this->assertFalse($this->is()->isEmpty(new Arrayable()));
    }

    public function testDoesntEmpty()
    {
        $this->assertFalse($this->is()->doesntEmpty(''));
        $this->assertFalse($this->is()->doesntEmpty(' '));
        $this->assertFalse($this->is()->doesntEmpty('      '));
        $this->assertFalse($this->is()->doesntEmpty(null));

        $this->assertTrue($this->is()->doesntEmpty(0));
        $this->assertTrue($this->is()->doesntEmpty('   0   '));
        $this->assertTrue($this->is()->doesntEmpty(false));

        $this->assertFalse($this->is()->doesntEmpty([]));
        $this->assertFalse($this->is()->doesntEmpty(new Foo()));

        $this->assertTrue($this->is()->doesntEmpty(new Bar()));
        $this->assertTrue($this->is()->doesntEmpty(new Baz()));
        $this->assertTrue($this->is()->doesntEmpty(new Baq()));
        $this->assertTrue($this->is()->doesntEmpty(new Arrayable()));
    }

    protected function is(): Is
    {
        return new Is();
    }
}
