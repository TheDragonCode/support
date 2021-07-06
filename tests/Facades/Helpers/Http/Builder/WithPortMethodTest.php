<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Exceptions\ForbiddenVariableTypeException;
use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithPortMethodTest extends Base
{
    public function testString()
    {
        $this->expectException(ForbiddenVariableTypeException::class);
        $this->expectExceptionMessage('Forbidden variable type: null, integer needles, string given.');

        BuilderFacade::withPort('');
    }

    public function testSet()
    {
        $this->assertIsNumeric(BuilderFacade::withPort($this->psr_port)->getPort());
        $this->assertSame($this->psr_port, BuilderFacade::withPort($this->psr_port)->getPort());
    }
}
