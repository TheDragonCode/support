<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class GetPathMethodTest extends Base
{
    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getPath());
        $this->assertSame('/foo/bar', $builder->getPath());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getPath());
        $this->assertEmpty($builder->getPath());
    }
}
