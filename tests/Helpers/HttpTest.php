<?php

namespace Tests\Helpers;

use Helldar\Support\Helpers\Http;
use Tests\TestCase;

class HttpTest extends TestCase
{
    public function testGetSubdomain()
    {
        $this->assertEquals('foo', Http::getSubdomain('https://foo.bar.example.com/foo/bar'));
        $this->assertEquals('foo', Http::getSubdomain('https://foo.example.com/foo/bar'));
        $this->assertEquals('', Http::getSubdomain('https://example.com/foo/bar'));
    }

    public function testExists()
    {

    }

    public function testIsUrl()
    {

    }

    public function testBuildUrl()
    {

    }

    public function testBaseUrl()
    {

    }
}
