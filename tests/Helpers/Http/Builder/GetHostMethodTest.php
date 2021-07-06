<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class GetHostMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getHost());
        $this->assertSame('en.example.com', $builder->getHost());
    }

    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getHost());
        $this->assertSame('en.example.com', $builder->getHost());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());
    }
}