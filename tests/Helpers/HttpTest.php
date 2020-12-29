<?php

namespace Tests\Helpers;

use ArgumentCountError;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Helpers\Http;
use Tests\TestCase;

final class HttpTest extends TestCase
{
    public function testDomain()
    {
        $this->assertSame('localhost', $this->http()->domain('http://localhost'));
        $this->assertSame('localhost', $this->http()->domain('https://localhost'));
        $this->assertSame('localhost', $this->http()->domain('ftp://localhost'));
        $this->assertSame('localhost', $this->http()->domain('ftp://localhost'));

        $this->assertSame('example.com', $this->http()->domain('https://example.com'));
        $this->assertSame('foo.example.com', $this->http()->domain('https://foo.example.com'));
        $this->assertSame('bar.example.com', $this->http()->domain('https://bar.example.com'));

        $this->assertSame('example.com', $this->http()->domain('https://example.com'));
        $this->assertSame('foo.example.com', $this->http()->domain('https://foo.example.com'));
        $this->assertSame('bar.example.com', $this->http()->domain('https://bar.example.com'));

        $this->assertSame('foo.example.com', $this->http()->domain('https://foo.example.com/foo/bar?id=1'));
    }

    public function testDomainThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        $this->http()->domain();
    }

    public function testDomainThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->domain('');
    }

    public function testDomainThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->domain(null);
    }

    public function testDomainThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->http()->domain('foo.bar');
    }

    public function testHost()
    {
        $this->assertSame('https://localhost', $this->http()->host('https://localhost/foo/bar?id=1'));
        $this->assertSame('https://foo.bar', $this->http()->host('https://foo.bar/baz/baq?id=1'));
        $this->assertSame('https://example.com', $this->http()->host('https://example.com'));
    }

    public function testHostThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->host(null);
    }

    public function testHostThrowIncorrectUri()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->http()->host('foo.bar');
    }

    public function testExists()
    {
        $this->assertTrue($this->http()->exists('https://google.com'));
        $this->assertTrue($this->http()->exists('https://yandex.com'));

        $this->assertFalse($this->http()->exists('https://aaa.a'));
        $this->assertFalse($this->http()->exists('https://bbb.b'));
    }

    public function testExistsThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->exists(null);
    }

    public function testExistsThrowIncorrectUri()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->http()->host('foo.bar');
    }

    public function testScheme()
    {
        $this->assertSame('https', $this->http()->scheme('https://localhost'));
        $this->assertSame('http', $this->http()->scheme('http://localhost'));
        $this->assertSame('ftp', $this->http()->scheme('ftp://localhost'));
        $this->assertSame('ws', $this->http()->scheme('ws://localhost'));
    }

    public function testSchemeThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        $this->http()->scheme();
    }

    public function testSchemeThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->scheme('');
    }

    public function testSchemeThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->scheme(null);
    }

    public function testSchemeThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->http()->scheme('foo.bar');
    }

    public function testSubdomain()
    {
        $this->assertNull($this->http()->subdomain('http://localhost'));
        $this->assertNull($this->http()->subdomain('https://localhost'));
        $this->assertNull($this->http()->subdomain('ftp://localhost'));
        $this->assertNull($this->http()->subdomain('ftp://localhost'));

        $this->assertSame('foo', $this->http()->subdomain('https://foo.example.com'));
        $this->assertSame('bar', $this->http()->subdomain('https://bar.example.com'));

        $this->assertSame('foo', $this->http()->subdomain('https://foo.example.com/foo/bar?id=1'));
    }

    public function testSubdomainThrowWithoutArguments()
    {
        $this->expectException(ArgumentCountError::class);

        $this->http()->subdomain();
    }

    public function testSubdomainThrowEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->subdomain('');
    }

    public function testSubdomainThrowNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "" is not a valid URL.');

        $this->http()->subdomain(null);
    }

    public function testSubdomainThrowIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->http()->subdomain('foo.bar');
    }

    public function testValidateUrlSuccess()
    {
        $this->http()->validateUrl('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateUrlIncorrect()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->http()->validateUrl('foo.bar');
    }

    public function testIsUrl()
    {
        $this->assertTrue($this->http()->isUrl('https://localhost'));
        $this->assertTrue($this->http()->isUrl('https://foo.bar'));
        $this->assertTrue($this->http()->isUrl('https://example.com'));
        $this->assertTrue($this->http()->isUrl('http://example.com'));
        $this->assertTrue($this->http()->isUrl('ftp://example.com'));
        $this->assertTrue($this->http()->isUrl('ws://example.com'));

        $this->assertFalse($this->http()->isUrl('localhost'));
        $this->assertFalse($this->http()->isUrl('://foo.bar'));
        $this->assertFalse($this->http()->isUrl('//example.com'));
    }

    public function testImage()
    {
        $image = 'https://github.githubassets.com/pinned-octocat.svg';
        $path  = $this->tempDirectory('foo.jpg');

        File::store($path, 'foo', 777);

        $this->assertSame($image, $this->http()->image($image));
        $this->assertSame($image, $this->http()->image($image, 'https://example.com/foo.jpg'));
        $this->assertNull($this->http()->image('https://aaa.a'));

        $this->assertSame('https://example.com/foo.jpg', $this->http()->image('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));

        $this->assertSame($path, $this->http()->image($path));
        $this->assertSame($path, $this->http()->image($path, '/foo/bar.jpg'));
        $this->assertSame('/foo/bar.jpg', $this->http()->image('foo.jpg', '/foo/bar.jpg'));
        $this->assertNull($this->http()->image('foo.jpg'));
    }

    protected function http(): Http
    {
        return new Http();
    }
}
