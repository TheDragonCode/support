<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetPasswordMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getPassword());
        $this->assertSame($this->psr_pass, $builder->getPassword());
    }

    public function testWithout()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getPassword());
        $this->assertEmpty($builder->getPassword());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getPassword());
        $this->assertEmpty(BuilderFacade::getPassword());
    }
}
