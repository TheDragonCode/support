<?php

namespace Tests\Facades\Http;

use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Http\Builder as BuilderHelper;
use Helldar\Support\Facades\Http\Url;
use Helldar\Support\Helpers\Http\Builder;
use Psr\Http\Message\UriInterface;
use Tests\TestCase;

class UrlTest extends TestCase
{
    protected $builder_url = 'https://example.com';

    public function testParse()
    {
        $url = 'https://github.githubassets.com/pinned-octocat.svg';

        $parsed = Url::parse($url);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testParseUriInterface()
    {
        $builder = $this->builder();

        $parsed = Url::parse($builder);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testExists()
    {
        $this->assertTrue(Url::exists('https://google.com'));
        $this->assertTrue(Url::exists('https://yandex.com'));

        $this->assertFalse(Url::exists('https://a.a'));
        $this->assertFalse(Url::exists('https://b.b'));
    }

    public function testExistsNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        Url::exists(null);
    }

    public function testExistsUriInterface()
    {
        $uri = $this->builder();

        $this->assertTrue(Url::exists($uri));
    }

    public function testIs()
    {
        $this->assertTrue(Url::is('https://localhost'));
        $this->assertTrue(Url::is('https://foo.bar'));
        $this->assertTrue(Url::is('https://example.com'));
        $this->assertTrue(Url::is('http://example.com'));
        $this->assertTrue(Url::is('ftp://example.com'));
        $this->assertTrue(Url::is('ws://example.com'));

        $this->assertTrue(Url::is($this->builder()));

        $this->assertFalse(Url::is('localhost'));
        $this->assertFalse(Url::is('://foo.bar'));
        $this->assertFalse(Url::is('//example.com'));
    }

    public function testValidated()
    {
        $url = 'https://example.com';

        $validated = Url::validated($url);

        $this->assertSame($url, $validated);
    }

    public function testValidatedUriInterface()
    {
        $builder = $this->builder();

        $validated = Url::validated($builder);

        $this->assertSame($this->builder_url, $validated);
    }

    public function testValidate()
    {
        Url::validate('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateUriInterface()
    {
        Url::validate($this->builder());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Url::validate('foo.bar');
    }

    public function testDefault()
    {
        $first = 'https://github.githubassets.com/pinned-octocat.svg';

        $this->assertSame($first, Url::default($first, 'https://example.com/foo.jpg'));

        $this->assertSame('https://example.com/foo.jpg', Url::default('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));
    }

    protected function builder(): Builder
    {
        return BuilderHelper::parse($this->builder_url);
    }
}
