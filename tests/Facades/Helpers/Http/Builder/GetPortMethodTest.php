<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetPortMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame($this->psr_port, $builder->getPort());
    }

    public function testEmpty()
    {
        $this->assertNull(BuilderFacade::getPort());
    }
}
