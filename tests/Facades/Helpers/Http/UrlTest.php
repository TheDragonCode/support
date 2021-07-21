<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************@author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 */

namespace Tests\Facades\Helpers\Http;

use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Http\Url as UrlFacade;
use Helldar\Support\Helpers\Http\Builder;
use Helldar\Support\Helpers\Http\Url;
use Psr\Http\Message\UriInterface;
use Tests\TestCase;

class UrlTest extends TestCase
{
    protected $test_url = 'https://example.com';

    public function testParse()
    {
        $url = 'https://github.githubassets.com/pinned-octocat.svg';

        $parsed = UrlFacade::parse($url);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testParsePsr()
    {
        $builder = $this->builder();

        $parsed = UrlFacade::parse($builder);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testExists()
    {
        $this->assertTrue(UrlFacade::exists('https://google.com'));
        $this->assertTrue(UrlFacade::exists('https://yandex.com'));

        $this->assertFalse(UrlFacade::exists('https://a.a'));
        $this->assertFalse(UrlFacade::exists('https://b.b'));
    }

    public function testExistsNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        UrlFacade::exists(null);
    }

    public function testExistsUriInterface()
    {
        $uri = $this->builder();

        $this->assertTrue(UrlFacade::exists($uri));
    }

    public function testIs()
    {
        $this->assertTrue(UrlFacade::is('https://localhost'));
        $this->assertTrue(UrlFacade::is('https://foo.bar'));
        $this->assertTrue(UrlFacade::is('https://example.com'));
        $this->assertTrue(UrlFacade::is('http://example.com'));
        $this->assertTrue(UrlFacade::is('ftp://example.com'));
        $this->assertTrue(UrlFacade::is('ws://example.com'));

        $this->assertTrue(UrlFacade::is($this->builder()));

        $this->assertFalse(UrlFacade::is('localhost'));
        $this->assertFalse(UrlFacade::is('://foo.bar'));
        $this->assertFalse(UrlFacade::is('//example.com'));
    }

    public function testValidated()
    {
        $url = 'https://example.com';

        $validated = UrlFacade::validated($url);

        $this->assertSame($url, $validated);
    }

    public function testValidatedPsr()
    {
        $builder = $this->builder();

        $validated = UrlFacade::validated($builder);

        $this->assertInstanceOf(UriInterface::class, $validated);
        $this->assertSame($this->test_url, (string) $validated);
    }

    public function testValidate()
    {
        UrlFacade::validate('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateDuplicateSlashes()
    {
        UrlFacade::validate('https://example.com/foo');
        UrlFacade::validate('https://example.com//foo');
        UrlFacade::validate('https://example.com///foo');
        UrlFacade::validate('https://example.com////foo');

        $this->assertTrue(true);
    }

    public function testValidateWithoutSchema()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "//example.com/foo" is not a valid URL.');

        UrlFacade::validate('//example.com/foo');
    }

    public function testValidateUriInterface()
    {
        UrlFacade::validate($this->builder());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        UrlFacade::validate('foo.bar');
    }

    public function testDefault()
    {
        $first = 'https://github.githubassets.com/pinned-octocat.svg';

        $this->assertSame($first, UrlFacade::default($first, 'https://example.com/foo.jpg'));

        $this->assertSame('https://example.com/foo.jpg', UrlFacade::default('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));
    }

    protected function url(): Url
    {
        return new Url();
    }

    protected function builder(): Builder
    {
        $builder = new Builder();

        return $builder->parse($this->test_url);
    }
}
