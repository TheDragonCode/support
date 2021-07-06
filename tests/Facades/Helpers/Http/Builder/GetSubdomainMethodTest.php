<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetSubdomainMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getSubDomain());
        $this->assertSame('en', $builder->getSubDomain());
    }

    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getSubDomain());
        $this->assertSame('en', $builder->getSubDomain());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getSubDomain());
        $this->assertEmpty(BuilderFacade::getSubDomain());
    }
}
