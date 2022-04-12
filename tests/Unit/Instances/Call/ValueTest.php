<?php

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Instances\Call;
use Tests\TestCase;

class ValueTest extends TestCase
{
    public function testValue()
    {
        $this->assertSame('foo', Call::value('foo'));
        $this->assertSame('foo', Call::value(fn () => 'foo'));
        $this->assertSame('foo', Call::value(fn ($val) => $val, 'foo'));
        $this->assertSame('foo', Call::value(fn ($val) => $val, ['foo']));
    }
}
