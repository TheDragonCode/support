<?php

namespace Tests\Facades\Helpers\Http;

use ArgumentCountError;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\Http\Builder;
use Helldar\Support\Helpers\Http\Builder as Helper;
use Helldar\Support\Tools\Http\Uri;
use Psr\Http\Message\UriInterface;
use RuntimeException;
use Tests\TestCase;

final class BuilderTest extends TestCase
{
    public function testInstance()
    {
        $this->assertInstanceOf(Helper::class, Builder::parse('http://localhost'));
        $this->assertInstanceOf(Helper::class, Builder::same());
    }

    public function testParseShort()
    {
        $builder = Builder::parse('https://localhost/foo/bar');

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
        $builder = Builder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty', PHP_URL_HOST);

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
        $builder = Builder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

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

        Builder::parse('foo.bar');
    }

    public function testParseEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Builder::parse('');
    }

    public function testParseNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Builder::parse(null);
    }

    public function testRawShort()
    {
        $parsed = parse_url('https://localhost/foo/bar');

        $builder = Builder::raw($parsed);

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

        $builder = Builder::raw($parsed);

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
        $builder = Builder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testRawIncorrect()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Filling in the "foo" key is prohibited.');

        $parsed = ['foo' => 'bar'];

        Builder::raw($parsed);
    }

    public function testCompileShort()
    {
        $builder = Builder::parse('https://localhost/foo/bar');

        $this->assertSame('https://localhost/foo/bar', $builder->compile());
    }

    public function testCompileFull()
    {
        $builder = Builder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

        $this->assertSame('https://foo:bar@localhost/foo/bar?id=123#qwerty', $builder->compile());
    }

    public function testCompileManual()
    {
        $builder = Builder::same()
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
        $builder = Builder::same()
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
        $builder = Builder::parse('https://foo:bar@example.com/foo/bar?id=123#qwerty');

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
        $builder = Builder::parse('https://example.com');

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

        Builder::setScheme('foo', 'bar', 'baz');
    }

    public function testArgumentCountTwo()
    {
        $this->expectException(ArgumentCountError::class);
        $this->expectExceptionMessage('setScheme expects at most 1 parameter, 2 given.');

        Builder::setScheme('foo', 'bar');
    }

    public function testSetScheme()
    {
        $this->assertNull(Builder::getScheme());

        Builder::setScheme('foo');

        $this->assertSame('foo', Builder::getScheme());
    }

    public function testSetFragment()
    {
        $this->assertNull(Builder::getFragment());

        Builder::setFragment('foo');

        $this->assertSame('foo', Builder::getFragment());
    }

    public function testSetHost()
    {
        $this->assertNull(Builder::getHost());

        Builder::setHost('foo');

        $this->assertSame('foo', v::getHost());
    }

    public function testSetPass()
    {
        $this->assertNull(Builder::getPass());

        Builder::setPass('foo');

        $this->assertSame('foo', Builder::getPass());
    }

    public function testSetPath()
    {
        $this->assertNull(Builder::getPath());

        Builder::setPath('foo');

        $this->assertSame('foo', Builder::getPath());
    }

    public function testSetPort()
    {
        $this->assertNull(Builder::getPort());

        Builder::setPort('foo');

        $this->assertSame('foo', Builder::getPort());
    }

    public function testSetQuery()
    {
        $this->assertNull(Builder::getQuery());

        Builder::setQuery('foo');

        $this->assertSame('0=foo', Builder::getQuery());
    }

    public function testSetUser()
    {
        $this->assertNull(Builder::getUser());

        Builder::setUser('foo');

        $this->assertSame('foo', Builder::getUser());
    }

    public function testPutFragment()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putFragment method not defined.');

        Builder::putFragment('foo', 'bar');
    }

    public function testPutHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putHost method not defined.');

        Builder::putHost('foo', 'bar');
    }

    public function testPutPass()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPass method not defined.');

        Builder::putPass('foo', 'bar');
    }

    public function testPutPath()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPath method not defined.');

        Builder::putPath('foo', 'bar');
    }

    public function testPutPort()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putPort method not defined.');

        Builder::putPort('foo', 'bar');
    }

    public function testPutQuery()
    {
        $builder = Builder::parse('https://foo:bar@localhost/foo/bar?id=123#qwerty');

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

        Builder::putScheme('foo', 'bar');
    }

    public function testPutUser()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('putUser method not defined.');

        Builder::putUser('foo', 'bar');
    }

    public function testRemoveFragment()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeFragment method not defined.');

        Builder::removeFragment('foo');
    }

    public function testRemoveHost()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeHost method not defined.');

        Builder::removeHost('foo');
    }

    public function testRemovePass()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePass method not defined.');

        Builder::removePass('foo');
    }

    public function testRemovePath()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePath method not defined.');

        Builder::removePath('foo');
    }

    public function testRemovePort()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removePort method not defined.');

        Builder::removePort('foo');
    }

    public function testRemoveQuery()
    {
        $builder = Builder::parse('https://foo:bar@localhost/foo/bar?id=123&qwe=rty&wa=sd#qwerty');

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

    public function testFromUriInterface()
    {
        $source = Builder::parse('https://foo:bar@localhost:8901/foo/bar?id=123&qwe=rty&wa=sd#qwerty');

        $uri = Uri::make($source);

        $builder = Builder::fromUriInterface($uri);

        $this->assertInstanceOf(Helper::class, $builder);

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('foo', $builder->getUser());
        $this->assertSame('bar', $builder->getPass());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame(8901, $builder->getPort());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123&qwe=rty&wa=sd', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());
    }

    public function testToUriInterface()
    {
        $builder = Builder::parse('https://foo:bar@localhost:8901/foo/bar?id=123&qwe=rty&wa=sd#qwerty');

        $uri = $builder->toUriInterface();

        $this->assertInstanceOf(UriInterface::class, $uri);

        $this->assertSame('https', $uri->getScheme());
        $this->assertSame('foo:bar', $uri->getUserInfo());
        $this->assertSame('foo:bar@localhost:8901', $uri->getAuthority());
        $this->assertSame('localhost', $uri->getHost());
        $this->assertSame(8901, $uri->getPort());
        $this->assertSame('/foo/bar', $uri->getPath());
        $this->assertSame('id=123&qwe=rty&wa=sd', $uri->getQuery());
        $this->assertSame('qwerty', $uri->getFragment());

        $this->assertSame('https://foo:bar@localhost:8901/foo/bar?id=123&qwe=rty&wa=sd#qwerty', (string) $uri);
    }

    public function testRemoveScheme()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeScheme method not defined.');

        Builder::removeScheme('foo');
    }

    public function testRemoveUser()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('removeUser method not defined.');

        Builder::removeUser('foo', 'bar');
    }

    public function testSetUnknown()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('setUnknown method not defined.');

        Builder::setUnknown('foo');
    }

    public function testGetUnknown()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getUnknown method not defined.');

        Builder::getUnknown('foo');
    }
}
