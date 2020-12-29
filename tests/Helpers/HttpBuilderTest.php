<?php

namespace Tests\Helpers;

use ArgumentCountError;
use Helldar\Support\Helpers\HttpBuilder as Helper;
use RuntimeException;
use Tests\TestCase;

final class HttpBuilderTest extends TestCase
{
    public function testInstance()
    {
        $this->assertTrue($this->builder()->parse('http://localhost') instanceof Helper);
        $this->assertTrue($this->builder()->same() instanceof Helper);
    }

    public function testParseShort()
    {
        $builder = $this->builder()->parse('https://localhost/foo/bar');

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
        $builder = $this->builder()->parse('https://foo:bar@localhost/foo/bar?id=123#qwerty', PHP_URL_HOST);

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
        $builder = $this->builder()->parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPass());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());
    }

    public function testRawShort()
    {
        $parsed = parse_url('https://localhost/foo/bar');

        $builder = $this->builder()->raw($parsed);

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());

        $this->assertNull($builder->getPort());
        $this->assertNull($builder->getUser());
        $this->assertNull($builder->getQuery());
        $this->assertNull($builder->getPass());
        $this->assertNull($builder->getFragment());
    }

    public function testRawFull()
    {
        $parsed = parse_url('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $builder = $this->builder()->raw($parsed);

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPass());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());
    }

    public function testRawCompile()
    {
        $builder = $this->builder()->parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testRawIncorrect()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Filling in the "foo" key is prohibited.');

        $parsed = ['foo' => 'bar'];

        $this->builder()->raw($parsed);
    }

    public function testCompileShort()
    {
        $builder = $this->builder()->parse('https://localhost/foo/bar');

        $this->assertSame('https://localhost/foo/bar', $builder->compile());
    }

    public function testCompileFull()
    {
        $builder = $this->builder()->parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testCompileManual()
    {
        $builder = $this->builder()->same()
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
        $builder = $this->builder()->same()
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

        $this->builder()->setScheme('foo', 'bar', 'baz');
    }

    public function testArgumentCountTwo()
    {
        $this->expectException(ArgumentCountError::class);
        $this->expectExceptionMessage('setScheme expects at most 1 parameter, 2 given.');

        $this->builder()->setScheme('foo', 'bar');
    }

    public function testSetScheme()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getScheme());

        $builder->setScheme('foo');

        $this->assertSame('foo', $builder->getScheme());
    }

    public function testSetFragment()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getFragment());

        $builder->setFragment('foo');

        $this->assertSame('foo', $builder->getFragment());
    }

    public function testSetHost()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getHost());

        $builder->setHost('foo');

        $this->assertSame('foo', $builder->getHost());
    }

    public function testSetPass()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getPass());

        $builder->setPass('foo');

        $this->assertSame('foo', $builder->getPass());
    }

    public function testSetPath()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getPath());

        $builder->setPath('foo');

        $this->assertSame('foo', $builder->getPath());
    }

    public function testSetPort()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getPort());

        $builder->setPort('foo');

        $this->assertSame('foo', $builder->getPort());
    }

    public function testSetQuery()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getQuery());

        $builder->setQuery('foo');

        $this->assertSame('foo', $builder->getQuery());
    }

    public function testSetUser()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getUser());

        $builder->setUser('foo');

        $this->assertSame('foo', $builder->getUser());
    }

    public function testSetUnknown()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('setUnknown method not defined.');

        $this->builder()->setUnknown('foo');
    }

    public function testGetUnknown()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getUnknown method not defined.');

        $this->builder()->getUnknown('foo');
    }

    protected function builder(): Helper
    {
        return new Helper();
    }
}
