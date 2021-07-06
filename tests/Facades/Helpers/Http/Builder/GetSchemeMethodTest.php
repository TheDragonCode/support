<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetSchemeMethodTest extends Base
{
    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getScheme());
        $this->assertSame($this->psr_scheme, $builder->getScheme());
    }

    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getScheme());
        $this->assertSame('https', $builder->getScheme());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getScheme());
        $this->assertEmpty(BuilderFacade::getScheme());
    }
}
