<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Sorter;

use DragonCode\Support\Callbacks\Sorter as Tool;
use Tests\TestCase;

abstract class Base extends TestCase
{
    public function testIsArrayValue()
    {
        $this->assertIsArray($this->sorter()->specialChars());
    }

    protected function sorter(): Tool
    {
        return new Tool();
    }
}
