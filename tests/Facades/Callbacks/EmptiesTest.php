<?php

namespace Tests\Facades\Callbacks;

use Helldar\Support\Facades\Callbacks\Empties;
use Tests\TestCase;

final class EmptiesTest extends TestCase
{
    public function testFilter()
    {
        $callback = Empties::filter();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }

    public function testFilterBoth()
    {
        $callback = Empties::filterBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }
}
