<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class ToStringMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString((string) $builder);

        $this->assertSame(rtrim($this->test_url, '/'), (string) $builder);
    }

    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString((string) $builder);

        $this->assertSame($this->psr_url, (string) $builder);
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString((string) $builder);

        $this->assertSame('', (string) $builder);
    }
}
