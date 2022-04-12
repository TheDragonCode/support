<?php

namespace Tests\Unit\Helpers\Arr;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class SpliceTest extends TestCase
{
    public function testSplice()
    {
        $this->assertSame(['bar', 'baz'], Arr::splice(['foo', 'bar', 'baz'], 0, 1));
        $this->assertSame(['baz'], Arr::splice(['foo', 'bar', 'baz'], 0, 2));

        $this->assertSame(['foo', 'baz'], Arr::splice(['foo', 'bar', 'baz'], 1, 1));

        $this->assertSame([], Arr::splice(['foo', 'bar', 'baz'], 0, 10));
        $this->assertSame([], Arr::splice(['foo', 'bar', 'baz'], 0));

        $this->assertSame(['foo', 'bar'], Arr::splice(['foo', 'bar', 'baz'], -1));
        $this->assertSame(['foo'], Arr::splice(['foo', 'bar', 'baz'], -2));
    }
}
