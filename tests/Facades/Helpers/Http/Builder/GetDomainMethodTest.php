<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetDomainMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getDomain());
        $this->assertSame('en.example.com', $builder->getDomain());
    }

    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getDomain());
        $this->assertSame('en.example.com', $builder->getDomain());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getDomain());
        $this->assertEmpty(BuilderFacade::getDomain());
    }
}
