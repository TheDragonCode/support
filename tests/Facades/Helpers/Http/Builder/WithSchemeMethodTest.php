<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithSchemeMethodTest extends Base
{
    public function testSet()
    {
        $this->assertIsString(BuilderFacade::withScheme($this->psr_scheme)->getScheme());
        $this->assertSame($this->psr_scheme, BuilderFacade::withScheme($this->psr_scheme)->getScheme());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::withScheme('')->getScheme());
        $this->assertEmpty(BuilderFacade::withScheme('')->getScheme());
    }

    public function testNull()
    {
        $this->assertIsString(BuilderFacade::withScheme(null)->getScheme());
        $this->assertEmpty(BuilderFacade::withScheme(null)->getScheme());
    }
}
