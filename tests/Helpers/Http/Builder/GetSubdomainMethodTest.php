<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class GetSubdomainMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getSubDomain());
        $this->assertSame('en', $builder->getSubDomain());
    }

    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getSubDomain());
        $this->assertSame('en', $builder->getSubDomain());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getSubDomain());
        $this->assertEmpty($builder->getSubDomain());
    }
}