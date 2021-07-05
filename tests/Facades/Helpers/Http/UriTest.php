<?php

namespace Tests\Facades\Helpers\Http;

use ArgumentCountError;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Http\Uri;
use Tests\TestCase;

final class UriTest extends TestCase
{
    public function testDomain()
    {
        $this->assertSame('localhost', Uri::domain('http://localhost'));
        $this->assertSame('localhost', Uri::domain('https://localhost'));
        $this->assertSame('localhost', Uri::domain('ftp://localhost'));
        $this->assertSame('localhost', Uri::domain('ftp://localhost'));

        $this->assertSame('example.com', Uri::domain('https://example.com'));
        $this->assertSame('foo.example.com', Uri::domain('https://foo.example.com'));
        $this->assertSame('bar.example.com', Uri::domain('https://bar.example.com'));

        $this->assertSame('example.com', Uri::domain('https://example.com'));
        $this->assertSame('foo.example.com', Uri::domain('https://foo.example.com'));
        $this->assertSame('bar.example.com', Uri::domain('https://bar.example.com'));

        $this->assertSame('foo.example.com', Uri::domain('https://foo.example.com/foo/bar?id=1'));
    }

    public function testDomainThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        Uri::domain();
    }

    public function testDomainThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::domain('');
    }

    public function testDomainThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::domain(null);
    }

    public function testDomainThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::domain('foo.bar');
    }

    public function testHost()
    {
        $this->assertSame('https://localhost', Uri::host('https://localhost/foo/bar?id=1'));
        $this->assertSame('https://foo.bar', Uri::host('https://foo.bar/baz/baq?id=1'));
        $this->assertSame('https://example.com', Uri::host('https://example.com'));
    }

    public function testHostThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::host(null);
    }

    public function testHostThrowIncorrectUri()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::host('foo.bar');
    }

    public function testExists()
    {
        $this->assertTrue(Uri::exists('https://google.com'));
        $this->assertTrue(Uri::exists('https://yandex.com'));

        $this->assertFalse(Uri::exists('https://aaa.a'));
        $this->assertFalse(Uri::exists('https://bbb.b'));
    }

    public function testExistsThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::exists(null);
    }

    public function testExistsThrowIncorrectUri()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::host('foo.bar');
    }

    public function testScheme()
    {
        $this->assertSame('https', Uri::scheme('https://localhost'));
        $this->assertSame('http', Uri::scheme('http://localhost'));
        $this->assertSame('ftp', Uri::scheme('ftp://localhost'));
        $this->assertSame('ws', Uri::scheme('ws://localhost'));
    }

    public function testSchemeThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        Uri::scheme();
    }

    public function testSchemeThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::scheme('');
    }

    public function testSchemeThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::scheme(null);
    }

    public function testSchemeThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::scheme('foo.bar');
    }

    public function testSubdomain()
    {
        $this->assertNull(Uri::subdomain('http://localhost'));
        $this->assertNull(Uri::subdomain('https://localhost'));
        $this->assertNull(Uri::subdomain('ftp://localhost'));
        $this->assertNull(Uri::subdomain('ftp://localhost'));

        $this->assertSame('foo', Uri::subdomain('https://foo.example.com'));
        $this->assertSame('bar', Uri::subdomain('https://bar.example.com'));

        $this->assertSame('foo', Uri::subdomain('https://foo.example.com/foo/bar?id=1'));
    }

    public function testSubdomainThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        Uri::subdomain();
    }

    public function testSubdomainThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::subdomain('');
    }

    public function testSubdomainThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        Uri::subdomain(null);
    }

    public function testSubdomainThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::subdomain('foo.bar');
    }

    public function testValidateUrlSuccess()
    {
        Uri::validateUrl('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateUrlIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::validateUrl('foo.bar');
    }

    public function testValidatedUrlSuccess()
    {
        $url = 'http://example.com/foo/bar';

        $validated = Uri::validatedUrl($url);

        $this->assertSame($url, $validated);
    }

    public function testValidatedUrlIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Uri::validatedUrl('foo.bar');
    }

    public function testIsUrl()
    {
        $this->assertTrue(Uri::isUrl('https://localhost'));
        $this->assertTrue(Uri::isUrl('https://foo.bar'));
        $this->assertTrue(Uri::isUrl('https://example.com'));
        $this->assertTrue(Uri::isUrl('http://example.com'));
        $this->assertTrue(Uri::isUrl('ftp://example.com'));
        $this->assertTrue(Uri::isUrl('ws://example.com'));

        $this->assertFalse(Uri::isUrl('localhost'));
        $this->assertFalse(Uri::isUrl('://foo.bar'));
        $this->assertFalse(Uri::isUrl('//example.com'));
    }

    public function testImage()
    {
        $image = 'https://github.githubassets.com/pinned-octocat.svg';
        $path  = $this->tempDirectory('foo.jpg');

        File::store($path, 'foo', 777);

        $this->assertSame($image, Uri::image($image));
        $this->assertSame($image, Uri::image($image, 'https://example.com/foo.jpg'));
        $this->assertNull(Uri::image('https://aaa.a'));

        $this->assertSame('https://example.com/foo.jpg', Uri::image('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));

        $this->assertSame($path, Uri::image($path));
        $this->assertSame($path, Uri::image($path, '/foo/bar.jpg'));
        $this->assertSame('/foo/bar.jpg', Uri::image('foo.jpg', '/foo/bar.jpg'));
        $this->assertNull(Uri::image('foo.jpg'));
    }
}
