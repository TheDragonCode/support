<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithFragmentMethodTest extends Base
{
    public function testSet()
    {
        $this->assertIsString(BuilderFacade::withFragment($this->psr_fragment)->getFragment());
        $this->assertSame($this->psr_fragment, BuilderFacade::withFragment($this->psr_fragment)->getFragment());
    }
}
