<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class ToArrayMethodTest extends Base
{
    public function testEmpty()
    {
        $this->assertSame([
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => null,
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ], BuilderFacade::toArray());
    }
}
