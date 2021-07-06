<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetFragmentMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getFragment());
        $this->assertSame($this->psr_fragment, $builder->getFragment());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getFragment());
        $this->assertEmpty(BuilderFacade::getFragment());
    }
}
