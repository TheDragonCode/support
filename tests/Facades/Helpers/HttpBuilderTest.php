<?php

namespace Tests\Facades\Helpers;

use ArgumentCountError;
use Helldar\Support\Facades\Helpers\HttpBuilder;
use Helldar\Support\Helpers\HttpBuilder as Helper;
use RuntimeException;
use Tests\TestCase;

final class HttpBuilderTest extends TestCase
{
    public function testInstance()
    {
        $this->assertTrue(HttpBuilder::parse('http://localhost') instanceof Helper);
        $this->assertTrue(HttpBuilder::same() instanceof Helper);
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
        $this->assertNull($builder->getPass());
        $this->assertNull($builder->getFragment());
    }

    public function testParseFull()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty', PHP_URL_HOST);

        $this->assertSame('localhost', $builder->getHost());

        $this->assertNull($builder->getScheme());
        $this->assertNull($builder->getUser());
        $this->assertNull($builder->getPass());
        $this->assertNull($builder->getPath());
        $this->assertNull($builder->getQuery());
        $this->assertNull($builder->getFragment());
    }

    public function testParseComponent()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPass());
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

    public function testCompileManual()
    {
        $builder = HttpBuilder::same()
            ->setScheme('https')
            ->setUser('foo')
            ->setPass('bar')
            ->setHost('localhost')
            ->setPath('foo/bar')
            ->setQuery(['id' => 123])
            ->setFragment('qwerty');

        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testCompileOverride()
    {
        $builder = HttpBuilder::same()
            ->setScheme('https')
            ->setScheme('http')
            ->setUser('foo')
            ->setPass('bar')
            ->setHost('localhost')
            ->setHost('example.com')
            ->setPath('foo/bar')
            ->setQuery('id=123')
            ->setFragment('qwerty');

        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('http://foo:bar@example.com/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testArgumentCountOne()
    {
        $this->expectException(ArgumentCountError::class);
        $this->expectExceptionMessage('setScheme expects at most 1 parameter, 3 given.');

        HttpBuilder::setScheme('foo', 'bar', 'baz');
    }

    public function testArgumentCountTwo()
    {
        $this->expectException(ArgumentCountError::class);
        $this->expectExceptionMessage('setScheme expects at most 1 parameter, 2 given.');

        HttpBuilder::setScheme('foo', 'bar');
    }

    public function testSetScheme()
    {
        $this->assertNull(HttpBuilder::getScheme());

        HttpBuilder::setScheme('foo');

        $this->assertSame('foo', HttpBuilder::getScheme());
    }

    public function testSetFragment()
    {
        $this->assertNull(HttpBuilder::getFragment());

        HttpBuilder::setFragment('foo');

        $this->assertSame('foo', HttpBuilder::getFragment());
    }

    public function testSetHost()
    {
        $this->assertNull(HttpBuilder::getHost());

        HttpBuilder::setHost('foo');

        $this->assertSame('foo', HttpBuilder::getHost());
    }

    public function testSetPass()
    {
        $this->assertNull(HttpBuilder::getPass());

        HttpBuilder::setPass('foo');

        $this->assertSame('foo', HttpBuilder::getPass());
    }

    public function testSetPath()
    {
        $this->assertNull(HttpBuilder::getPath());

        HttpBuilder::setPath('foo');

        $this->assertSame('foo', HttpBuilder::getPath());
    }

    public function testSetPort()
    {
        $this->assertNull(HttpBuilder::getPort());

        HttpBuilder::setPort('foo');

        $this->assertSame('foo', HttpBuilder::getPort());
    }

    public function testSetQuery()
    {
        $this->assertNull(HttpBuilder::getQuery());

        HttpBuilder::setQuery('foo');

        $this->assertSame('foo', HttpBuilder::getQuery());
    }

    public function testSetUser()
    {
        $this->assertNull(HttpBuilder::getUser());

        HttpBuilder::setUser('foo');

        $this->assertSame('foo', HttpBuilder::getUser());
    }

    public function testSetUnknown()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('setUnknown method not defined.');

        HttpBuilder::setUnknown('foo');
    }

    public function testGetUnknown()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getUnknown method not defined.');

        HttpBuilder::getUnknown('foo');
    }
}
