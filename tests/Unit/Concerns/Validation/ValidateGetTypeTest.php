<?php

namespace Tests\Unit\Concerns\Validation;

use DragonCode\Support\Concerns\Validation;
use Tests\TestCase;

class ValidateGetTypeTest extends TestCase
{
    use Validation;

    public function testValidate()
    {
        $this->assertSame('string', $this->validateGetType(static::class));

        $this->assertSame('object', $this->validateGetType($this));
    }
}
