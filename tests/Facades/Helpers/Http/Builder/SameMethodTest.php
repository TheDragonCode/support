<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Helldar\Support\Helpers\Http\Builder;
use Psr\Http\Message\UriInterface;
use Tests\Facades\Helpers\Http\Base;

class SameMethodTest extends Base
{
    public function testBuilder()
    {
        $this->assertInstanceOf(Builder::class, BuilderFacade::same());
        $this->assertInstanceOf(Builder::class, BuilderFacade::same()->parse($this->test_url)->same());
        $this->assertInstanceOf(Builder::class, BuilderFacade::parse($this->test_url)->same());
    }

    public function testInterface()
    {
        $this->assertInstanceOf(UriInterface::class, BuilderFacade::same());
        $this->assertInstanceOf(UriInterface::class, BuilderFacade::same()->parse($this->test_url)->same());
        $this->assertInstanceOf(UriInterface::class, BuilderFacade::parse($this->test_url)->same());
    }
}
