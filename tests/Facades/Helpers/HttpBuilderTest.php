<?php

namespace Tests\Facades\Helpers;

use Helldar\Support\Facades\Helpers\HttpBuilder;
use Helldar\Support\Helpers\HttpBuilder as Helper;
use Tests\TestCase;

final class HttpBuilderTest extends TestCase
{
    public function testInstance()
    {
        $this->assertTrue(HttpBuilder::parse('http://localhost') instanceof Helper);
    }

    public function testParseShort()
    {
        $builder = HttpBuilder::parse('https://localhost/foo/bar');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());

        $this->assertNull($builder->getPort());
        $this->assertNull($builder->getUser());
        $this->assertNull($builder->getQuery());
        $this->assertNull($builder->getPassword());
        $this->assertNull($builder->getFragment());
    }

    public function testParseFull()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty', PHP_URL_HOST);

        $this->assertSame('localhost', $builder->getHost());

        $this->assertNull($builder->getScheme());
        $this->assertNull($builder->getUser());
        $this->assertNull($builder->getPassword());
        $this->assertNull($builder->getPath());
        $this->assertNull($builder->getQuery());
        $this->assertNull($builder->getFragment());
    }

    public function testParseComponent()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPassword());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());
    }

    public function testCompileShort()
    {
        $builder = HttpBuilder::parse('https://localhost/foo/bar');

        $this->assertSame('https://localhost/foo/bar', $builder->compile());
    }

    public function testCompileFull()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }
}
