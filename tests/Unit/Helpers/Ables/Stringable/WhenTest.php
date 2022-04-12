<?php

namespace Tests\Unit\Helpers\Ables\Stringable;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class WhenTest extends TestCase
{
    public function testTrue()
    {
        $this->assertSame('QWERTY', Str::of('qwerty')->when(true, fn ($value) => Str::upper($value))->toString());
    }

    public function testFalse()
    {
        $this->assertSame('qwerty', Str::of('qwerty')->when(false, fn ($value) => Str::upper($value))->toString());
    }
}
