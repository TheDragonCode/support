<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetHostMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getHost());
        $this->assertSame('en.example.com', $builder->getHost());
    }

    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getHost());
        $this->assertSame('en.example.com', $builder->getHost());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getHost());
        $this->assertEmpty(BuilderFacade::getHost());
    }
}
