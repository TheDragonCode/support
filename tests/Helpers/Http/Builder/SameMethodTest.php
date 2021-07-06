<?php

namespace Tests\Helpers\Http\Builder;

use Helldar\Support\Helpers\Http\Builder;
use Psr\Http\Message\UriInterface;
use Tests\Helpers\Http\Base;

class SameMethodTest extends Base
{
    public function testBuilder()
    {
        $this->assertInstanceOf(Builder::class, $this->builder()->same());
        $this->assertInstanceOf(Builder::class, $this->builder()->same()->parse($this->test_url)->same());
        $this->assertInstanceOf(Builder::class, $this->builder()->parse($this->test_url)->same());
    }

    public function testInterface()
    {
        $this->assertInstanceOf(UriInterface::class, $this->builder()->same());
        $this->assertInstanceOf(UriInterface::class, $this->builder()->same()->parse($this->test_url)->same());
        $this->assertInstanceOf(UriInterface::class, $this->builder()->parse($this->test_url)->same());
    }
}
