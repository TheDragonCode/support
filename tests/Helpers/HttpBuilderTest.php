<?php

namespace Tests\Helpers;

use ArgumentCountError;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Helpers\HttpBuilder as Helper;
use RuntimeException;
use Tests\TestCase;

final class HttpBuilderTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Helper::class, $this->builder()->parse('http://localhost'));
        $this->assertInstanceOf(Helper::class, $this->builder()->same());
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

    public function testParseIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->builder()->parse('foo.bar');
    }

    public function testParseEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->builder()->parse('');
    }

    public function testParseNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->builder()->parse(null);
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

    public function testFullToArray()
    {
        $builder = $this->builder()->parse('https://foo:bar@example.com/foo/bar?id=123#qwerty');

        $this->assertIsArray($builder->toArray());

        $this->assertSame([
            'scheme'   => 'https',
            'host'     => 'example.com',
            'port'     => null,
            'user'     => 'foo',
            'pass'     => 'bar',
            'query'    => 'id=123',
            'path'     => '/foo/bar',
            'fragment' => 'qwerty',
        ], $builder->toArray());
    }

    public function testShortToArray()
    {
        $builder = $this->builder()->parse('https://example.com');

        $this->assertIsArray($builder->toArray());

        $this->assertSame([
            'scheme'   => 'https',
            'host'     => 'example.com',
            'port'     => null,
            'user'     => null,
            'pass'     => null,
            'query'    => null,
            'path'     => null,
            'fragment' => null,
        ], $builder->toArray());
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

        $this->assertSame('0=foo', $builder->getQuery());
    }

    public function testSetUser()
    {
        $builder = $this->builder();

        $this->assertNull($builder->getUser());

        $builder->setUser('foo');

        $this->assertSame('foo', $builder->getUser());
    }

    public function testPutFragment()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putFragment method not defined.');

        $this->builder()->putFragment('foo', 'bar');
    }

    public function testPutHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putHost method not defined.');

        $this->builder()->putHost('foo', 'bar');
    }

    public function testPutPass()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPass method not defined.');

        $this->builder()->putPass('foo', 'bar');
    }

    public function testPutPath()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPath method not defined.');

        $this->builder()->putPath('foo', 'bar');
    }

    public function testPutPort()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPort method not defined.');

        $this->builder()->putPort('foo', 'bar');
    }

    public function testPutQuery()
    {
        $builder = $this->builder()->parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPass());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());

        $builder->putQuery('qwe', 'rty');
        $builder->putQuery('wa', 'sd');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123&qwe=rty&wa=sd#qwerty', $builder->compile());
        $this->assertNotSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testPutScheme()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putScheme method not defined.');

        $this->builder()->putScheme('foo', 'bar');
    }

    public function testPutUser()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putUser method not defined.');

        $this->builder()->putUser('foo', 'bar');
    }

    public function testRemoveFragment()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeFragment method not defined.');

        $this->builder()->removeFragment('foo');
    }

    public function testRemoveHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeHost method not defined.');

        $this->builder()->removeHost('foo');
    }

    public function testRemovePass()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePass method not defined.');

        $this->builder()->removePass('foo');
    }

    public function testRemovePath()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePath method not defined.');

        $this->builder()->removePath('foo');
    }

    public function testRemovePort()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePort method not defined.');

        $this->builder()->removePort('foo');
    }

    public function testRemoveQuery()
    {
        $builder = $this->builder()->parse('https://foo:bar@localhost/foo/bar?id=123&qwe=rty&wa=sd#qwerty');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPass());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123&qwe=rty&wa=sd', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());

        $builder->removeQuery('qwe');
        $builder->removeQuery('wa');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
        $this->assertNotSame('https://foo:bar@localhost/foo/bar?id=123&qwe=rty&wa=sd#qwerty', $builder->compile());
    }

    public function testRemoveScheme()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeScheme method not defined.');

        $this->builder()->removeScheme('foo');
    }

    public function testRemoveUser()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeUser method not defined.');

        $this->builder()->removeUser('foo', 'bar');
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
