<?php

namespace Tests\Callbacks;

use Helldar\Support\Callbacks\Empties;
use Tests\TestCase;

final class EmptiesTest extends TestCase
{
    public function testFilter()
    {
        $callback = $this->call()->notEmpty();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }

    public function testFilterBoth()
    {
        $callback = $this->call()->notEmptyBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }

    protected function call(): Empties
    {
        return new Empties();
    }
}
