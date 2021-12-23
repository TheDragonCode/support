<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Empties;

class NotEmptyTest extends Base
{
    public function testFilter()
    {
        $callback = $this->call()->notEmpty();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo'));
        $this->assertFalse($callback(null));
    }
}
