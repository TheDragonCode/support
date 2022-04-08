<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

use DragonCode\Support\Facades\Callbacks\Sorter;

class DefaultTest extends Base
{
    public function testDefaultCallback()
    {
        $callback = Sorter::default();

        $this->assertIsCallable($callback);

        $this->assertSame(0, $callback(0, 0));
        $this->assertSame(0, $callback('0', '0'));
        $this->assertSame(0, $callback('foo', 'foo'));

        $this->assertSame(-1, $callback('#', 2));
        $this->assertSame(1, $callback('foo', 2));

        $this->assertSame(1, $callback(2, '#'));
        $this->assertSame(-1, $callback(2, 'foo'));

        $this->assertSame(-1, $callback('a', 'b'));
        $this->assertSame(-1, $callback('foo', 'foz'));
        $this->assertSame(-1, $callback('baz', 'qwe'));

        $this->assertSame(1, $callback('b', 'a'));
        $this->assertSame(1, $callback('foz', 'foo'));
        $this->assertSame(1, $callback('qwe', 'baz'));
    }
}
