<?php

namespace Tests\Facades\Helpers;

use ArgumentCountError;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\HttpBuilder;
use Helldar\Support\Helpers\HttpBuilder as Helper;
use RuntimeException;
use Tests\TestCase;

final class HttpBuilderTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Helper::class, HttpBuilder::parse('http://localhost'));
        $this->assertInstanceOf(Helper::class, HttpBuilder::same());
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

    public function testParseIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        HttpBuilder::parse('foo.bar');
    }

    public function testParseEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        HttpBuilder::parse('');
    }

    public function testParseNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        HttpBuilder::parse(null);
    }

    public function testRawShort()
    {
        $parsed = parse_url('https://localhost/foo/bar');

        $builder = HttpBuilder::raw($parsed);

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

        $builder = HttpBuilder::raw($parsed);

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
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testRawIncorrect()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Filling in the "foo" key is prohibited.');

        $parsed = ['foo' => 'bar'];

        HttpBuilder::raw($parsed);
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

    public function testFullToArray()
    {
        $builder = HttpBuilder::parse('https://foo:bar@example.com/foo/bar?id=123#qwerty');

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
        $builder = HttpBuilder::parse('https://example.com');

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

        $this->assertSame('0=foo', HttpBuilder::getQuery());
    }

    public function testSetUser()
    {
        $this->assertNull(HttpBuilder::getUser());

        HttpBuilder::setUser('foo');

        $this->assertSame('foo', HttpBuilder::getUser());
    }

    public function testPutFragment()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putFragment method not defined.');

        HttpBuilder::putFragment('foo', 'bar');
    }

    public function testPutHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putHost method not defined.');

        HttpBuilder::putHost('foo', 'bar');
    }

    public function testPutPass()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPass method not defined.');

        HttpBuilder::putPass('foo', 'bar');
    }

    public function testPutPath()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPath method not defined.');

        HttpBuilder::putPath('foo', 'bar');
    }

    public function testPutPort()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPort method not defined.');

        HttpBuilder::putPort('foo', 'bar');
    }

    public function testPutQuery()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

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

        HttpBuilder::putScheme('foo', 'bar');
    }

    public function testPutUser()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putUser method not defined.');

        HttpBuilder::putUser('foo', 'bar');
    }

    public function testRemoveFragment()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeFragment method not defined.');

        HttpBuilder::removeFragment('foo');
    }

    public function testRemoveHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeHost method not defined.');

        HttpBuilder::removeHost('foo');
    }

    public function testRemovePass()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePass method not defined.');

        HttpBuilder::removePass('foo');
    }

    public function testRemovePath()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePath method not defined.');

        HttpBuilder::removePath('foo');
    }

    public function testRemovePort()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePort method not defined.');

        HttpBuilder::removePort('foo');
    }

    public function testRemoveQuery()
    {
        $builder = HttpBuilder::parse('https://foo:bar@localhost/foo/bar?id=123&qwe=rty&wa=sd#qwerty');

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

        HttpBuilder::removeScheme('foo');
    }

    public function testRemoveUser()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeUser method not defined.');

        HttpBuilder::removeUser('foo', 'bar');
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
