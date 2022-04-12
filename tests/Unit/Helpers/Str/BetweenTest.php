<?php

namespace Tests\Unit\Helpers\Str;

use DragonCode\Support\Facades\Helpers\Str;
use Tests\TestCase;

class BetweenTest extends TestCase
{
    public function testBetween()
    {
        $this->assertSame('dragon', Str::between('the dragon code', 'the', 'code'));
        $this->assertSame(' dragon ', Str::between('the dragon code', 'the', 'code', false));
    }
}
