<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithPathMethodTest extends Base
{
    public function testWithoutPrefix()
    {
        $this->assertIsString(BuilderFacade::withPath('foo/bar')->getPath());
        $this->assertSame('/foo/bar', BuilderFacade::withPath('foo/bar')->getPath());
    }

    public function testWithPrefix()
    {
        $this->assertIsString(BuilderFacade::withPath('/foo/bar')->getPath());
        $this->assertSame('/foo/bar', BuilderFacade::withPath('/foo/bar')->getPath());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::withPath('')->getPath());
        $this->assertSame('', BuilderFacade::withPath('')->getPath());
    }

    public function testNull()
    {
        $this->assertIsString(BuilderFacade::withPath(null)->getPath());
        $this->assertSame('', BuilderFacade::withPath(null)->getPath());
    }
}
