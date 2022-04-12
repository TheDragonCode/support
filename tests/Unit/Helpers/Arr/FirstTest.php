<?php

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class FirstTest extends TestCase
{
    public function testFirst()
    {
        $array = [100, 200, 300];

        // Callback is null and array is empty
        $this->assertNull(Arr::first([]));
        $this->assertSame('foo', Arr::first([], default: 'foo'));
        $this->assertSame('bar', Arr::first([], default: static fn () => 'bar'));

        // Callback is null and array is not empty
        $this->assertEquals(100, Arr::first($array));

        // Callback is not null and array is not empty
        $value = Arr::first($array, static fn ($value) => $value > 150);
        $this->assertEquals(200, $value);

        // Callback is not null, array is not empty but no satisfied item
        $value2 = Arr::first($array, static fn ($value) => $value > 300);
        $value3 = Arr::first($array, static fn ($value) => $value > 300, 'bar');
        $value4 = Arr::first($array, static fn ($value) => $value > 300, static fn () => 'baz');

        $this->assertNull($value2);

        $this->assertSame('bar', $value3);
        $this->assertSame('baz', $value4);
    }
}
