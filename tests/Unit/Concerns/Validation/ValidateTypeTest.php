<?php

namespace Tests\Unit\Concerns\Validation;

use DragonCode\Support\Concerns\Validation;
use DragonCode\Support\Exceptions\ForbiddenVariableTypeException;
use Tests\TestCase;

class ValidateTypeTest extends TestCase
{
    use Validation;

    public function testAsString()
    {
        $this->validateType(static::class, 'string');

        $this->assertTrue(true);
    }

    public function testAsObject()
    {
        $this->validateType($this, 'object');

        $this->assertTrue(true);
    }

    public function testForbidden()
    {
        $this->expectException(ForbiddenVariableTypeException::class);
        $this->expectExceptionMessage('Forbidden variable type: int needles, object given.');

        $this->validateType($this, 'int');
    }
}
