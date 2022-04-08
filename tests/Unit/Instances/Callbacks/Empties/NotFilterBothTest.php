<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Empties;

use DragonCode\Support\Facades\Callbacks\Empties;
use Tests\TestCase;

class NotFilterBothTest extends TestCase
{
    public function testFilterBoth()
    {
        $callback = Empties::notEmptyBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }
}
