<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class ToUrlMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame(rtrim($this->test_url, '/'), $builder->toUrl());
    }

    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame($this->psr_url, $builder->toUrl());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::toUrl());

        $this->assertSame('', BuilderFacade::toUrl());
    }
}
