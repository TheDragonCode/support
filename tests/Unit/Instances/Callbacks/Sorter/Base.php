<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

use DragonCode\Support\Facades\Callbacks\Sorter;
use Tests\TestCase;

abstract class Base extends TestCase
{
    public function testIsArrayValue()
    {
        $this->assertIsArray(Sorter::specialChars());
    }
}
