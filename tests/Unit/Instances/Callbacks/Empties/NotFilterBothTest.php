<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Empties;

class NotFilterBothTest extends Base
{
    public function testFilterBoth()
    {
        $callback = $this->call()->notEmptyBoth();

        $this->assertIsCallable($callback);

        $this->assertTrue($callback('foo', 'bar'));
        $this->assertFalse($callback(null, null));
    }
}
