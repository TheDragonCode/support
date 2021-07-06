<?php

namespace Tests\Helpers\Http\Builder;

use Helldar\Support\Helpers\Http\Builder;
use Psr\Http\Message\UriInterface;
use Tests\Helpers\Http\Base;

class ToPsrMethodTest extends Base
{
    public function testBuilder()
    {
        $this->assertInstanceOf(Builder::class, $this->builder()->toPsr());
        $this->assertInstanceOf(Builder::class, $this->builder()->same()->parse($this->test_url)->toPsr());
        $this->assertInstanceOf(Builder::class, $this->builder()->parse($this->test_url)->toPsr());
    }

    public function testInterface()
    {
        $this->assertInstanceOf(UriInterface::class, $this->builder()->toPsr());
        $this->assertInstanceOf(UriInterface::class, $this->builder()->same()->parse($this->test_url)->toPsr());
        $this->assertInstanceOf(UriInterface::class, $this->builder()->parse($this->test_url)->toPsr());
    }
}
