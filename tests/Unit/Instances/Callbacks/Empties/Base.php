<?php

declare(strict_types=1);

namespace Tests\Unit\Instances\Callbacks\Empties;

use DragonCode\Support\Callbacks\Empties;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected function call(): Empties
    {
        return new Empties();
    }
}
