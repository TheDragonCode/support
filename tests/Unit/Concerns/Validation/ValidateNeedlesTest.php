<?php

namespace Tests\Unit\Concerns\Validation;

use DragonCode\Support\Concerns\Validation;
use Tests\TestCase;

class ValidateNeedlesTest extends TestCase
{
    use Validation;

    public function testValidate()
    {
        $source = [
            'FOO',
            'BaR',
            'BAm',
            'qwerty',
        ];

        $expected = [
            'foo',
            'bar',
            'bam',
            'qwerty',
        ];

        $this->assertSame($expected, $this->validateNeedles($source));
    }
}
