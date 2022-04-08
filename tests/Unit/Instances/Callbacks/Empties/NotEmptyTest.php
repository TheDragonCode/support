<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Empties;

use DragonCode\Support\Facades\Callbacks\Empties;
use Tests\TestCase;

class NotEmptyTest extends TestCase
{
    public function testFilter()
    {
        $callback = Empties::notEmpty();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }
}
