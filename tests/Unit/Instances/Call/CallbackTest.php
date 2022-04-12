<?php

namespace Tests\Unit\Instances\Call;

use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Instances\Call;
use Tests\TestCase;

class CallbackTest extends TestCase
{
    public function testCallback()
    {
        $this->assertSame('foo', Call::callback(fn () => 'foo'));
        $this->assertSame('FOO', Call::callback(fn ($value) => Str::upper($value), 'foo'));

        $this->assertNull(Call::callback('foo'));
        $this->assertNull(Call::callback('123'));
        $this->assertNull(Call::callback(123));
    }
}
