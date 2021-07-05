<?php

namespace Tests\Facades\Helpers;

use ArgumentCountError;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Http;
use Tests\TestCase;

/** @deprecated */
class HttpTest extends TestCase
{
    public function testDomain()
    {
        $this->assertSame('localhost', Http::domain('http://localhost'));
        $this->assertSame('localhost', Http::domain('https://localhost'));
        $this->assertSame('localhost', Http::domain('ftp://localhost'));
        $this->assertSame('localhost', Http::domain('ftp://localhost'));

        $this->assertSame('example.com', Http::domain('https://example.com'));
        $this->assertSame('foo.example.com', Http::domain('https://foo.example.com'));
        $this->assertSame('bar.example.com', Http::domain('https://bar.example.com'));

        $this->assertSame('example.com', Http::domain('https://example.com'));
        $this->assertSame('foo.example.com', Http::domain('https://foo.example.com'));
        $this->assertSame('bar.example.com', Http::domain('https://bar.example.com'));

        $this->assertSame('foo.example.com', Http::domain('https://foo.example.com/foo/bar?id=1'));
    }

    public function testDomainThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        Http::domain();
    }

    public function testDomainThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::domain('');
    }

    public function testDomainThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::domain(null);
    }

    public function testDomainThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::domain('foo.bar');
    }

    public function testHost()
    {
        $this->assertSame('https://localhost', Http::host('https://localhost/foo/bar?id=1'));
        $this->assertSame('https://foo.bar', Http::host('https://foo.bar/baz/baq?id=1'));
        $this->assertSame('https://example.com', Http::host('https://example.com'));
    }

    public function testHostThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::host(null);
    }

    public function testHostThrowIncorrectUri()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::host('foo.bar');
    }

    public function testExists()
    {
        $this->assertTrue(Http::exists('https://google.com'));
        $this->assertTrue(Http::exists('https://yandex.com'));

        $this->assertFalse(Http::exists('https://aaa.a'));
        $this->assertFalse(Http::exists('https://bbb.b'));
    }

    public function testExistsThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::exists(null);
    }

    public function testExistsThrowIncorrectUri()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::host('foo.bar');
    }

    public function testScheme()
    {
        $this->assertSame('https', Http::scheme('https://localhost'));
        $this->assertSame('http', Http::scheme('http://localhost'));
        $this->assertSame('ftp', Http::scheme('ftp://localhost'));
        $this->assertSame('ws', Http::scheme('ws://localhost'));
    }

    public function testSchemeThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        Http::scheme();
    }

    public function testSchemeThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::scheme('');
    }

    public function testSchemeThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::scheme(null);
    }

    public function testSchemeThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::scheme('foo.bar');
    }

    public function testSubdomain()
    {
        $this->assertNull(Http::subdomain('http://localhost'));
        $this->assertNull(Http::subdomain('https://localhost'));
        $this->assertNull(Http::subdomain('ftp://localhost'));
        $this->assertNull(Http::subdomain('ftp://localhost'));

        $this->assertSame('foo', Http::subdomain('https://foo.example.com'));
        $this->assertSame('bar', Http::subdomain('https://bar.example.com'));

        $this->assertSame('foo', Http::subdomain('https://foo.example.com/foo/bar?id=1'));
    }

    public function testSubdomainThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        Http::subdomain();
    }

    public function testSubdomainThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::subdomain('');
    }

    public function testSubdomainThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Http::subdomain(null);
    }

    public function testSubdomainThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::subdomain('foo.bar');
    }

    public function testValidateUrlSuccess()
    {
        Http::validateUrl('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateUrlIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::validateUrl('foo.bar');
    }

    public function testValidatedUrlSuccess()
    {
        $url = 'http://example.com/foo/bar';

        $validated = Http::validatedUrl($url);

        $this->assertSame($url, $validated);
    }

    public function testValidatedUrlIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Http::validatedUrl('foo.bar');
    }

    public function testIsUrl()
    {
        $this->assertTrue(Http::isUrl('https://localhost'));
        $this->assertTrue(Http::isUrl('https://foo.bar'));
        $this->assertTrue(Http::isUrl('https://example.com'));
        $this->assertTrue(Http::isUrl('http://example.com'));
        $this->assertTrue(Http::isUrl('ftp://example.com'));
        $this->assertTrue(Http::isUrl('ws://example.com'));

        $this->assertFalse(Http::isUrl('localhost'));
        $this->assertFalse(Http::isUrl('://foo.bar'));
        $this->assertFalse(Http::isUrl('//example.com'));
    }

    public function testImage()
    {
        $image = 'https://github.githubassets.com/pinned-octocat.svg';
        $path  = $this->tempDirectory('foo.jpg');

        File::store($path, 'foo', 777);

        $this->assertSame($image, Http::image($image));
        $this->assertSame($image, Http::image($image, 'https://example.com/foo.jpg'));
        $this->assertNull(Http::image('https://aaa.a'));

        $this->assertSame('https://example.com/foo.jpg', Http::image('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));

        $this->assertSame($path, Http::image($path));
        $this->assertSame($path, Http::image($path, '/foo/bar.jpg'));
        $this->assertSame('/foo/bar.jpg', Http::image('foo.jpg', '/foo/bar.jpg'));
        $this->assertNull(Http::image('foo.jpg'));
    }
}
