<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetPathMethodTest extends Base
{
    public function testFull()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getPath());
        $this->assertSame('/foo/bar', $builder->getPath());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getPath());
        $this->assertEmpty(BuilderFacade::getPath());
    }
}
