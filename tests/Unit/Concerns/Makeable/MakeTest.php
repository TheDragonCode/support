<?php

namespace Tests\Unit\Concerns\Makeable;

use DragonCode\Support\Concerns\Makeable;
use Tests\Fixtures\Instances\Bat;
use Tests\TestCase;

class MakeTest extends TestCase
{
    use Makeable;

    public function testEmpty()
    {
        $object = Bat::make();

        $this->assertNull($object->foo);
        $this->assertNull($object->bar);
    }

    public function testValue()
    {
        $object = Bat::make('Foo', 'Bar');

        $this->assertSame('Foo', $object->foo);
        $this->assertSame('Bar', $object->bar);
    }

    public function testStatic()
    {
        $this->assertInstanceOf(static::class, self::make());
    }
}