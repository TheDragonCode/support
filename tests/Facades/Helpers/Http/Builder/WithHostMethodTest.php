<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithHostMethodTest extends Base
{
    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::withHost('')->getHost());
        $this->assertEmpty(BuilderFacade::withHost('')->getHost());
    }

    public function testNull()
    {
        $this->assertIsString(BuilderFacade::withHost(null)->getHost());
        $this->assertEmpty(BuilderFacade::withHost(null)->getHost());
    }
}
