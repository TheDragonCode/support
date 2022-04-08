<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Instances\Helpers\Http;

use DragonCode\Support\Exceptions\NotValidUrlException;
use DragonCode\Support\Helpers\Http\Builder;
use DragonCode\Support\Helpers\Http\Url;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\UriInterface;
use Tests\TestCase;

class UrlTest extends TestCase
{
    protected string $test_url = 'https://example.com';

    public function testParse()
    {
        $url = 'https://github.githubassets.com/pinned-octocat.svg';

        $parsed = $this->url()->parse($url);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testParseUriInterface()
    {
        $builder = $this->builder();

        $parsed = $this->url()->parse($builder);

        $this->assertInstanceOf(Builder::class, $parsed);
        $this->assertInstanceOf(UriInterface::class, $parsed);
    }

    public function testExists()
    {
        $this->assertTrue($this->url()->exists('https://google.com'));
        $this->assertTrue($this->url()->exists('https://yandex.com'));

        $this->assertFalse($this->url()->exists('https://a.a'));
        $this->assertFalse($this->url()->exists('https://b.b'));
    }

    public function testExistsNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        $this->url()->exists(null);
    }

    public function testExistsUriInterface()
    {
        $uri = $this->builder();

        $this->assertTrue($this->url()->exists($uri));
    }

    public function testIs()
    {
        $this->assertTrue($this->url()->is('https://localhost'));
        $this->assertTrue($this->url()->is('https://foo.bar'));
        $this->assertTrue($this->url()->is('https://example.com'));
        $this->assertTrue($this->url()->is('http://example.com'));
        $this->assertTrue($this->url()->is('ftp://example.com'));
        $this->assertTrue($this->url()->is('ws://example.com'));

        $this->assertTrue($this->url()->is($this->builder()));

        $this->assertFalse($this->url()->is('localhost'));
        $this->assertFalse($this->url()->is('://foo.bar'));
        $this->assertFalse($this->url()->is('//example.com'));
    }

    public function testValidated()
    {
        $url = 'https://example.com';

        $validated = $this->url()->validated($url);

        $this->assertSame($url, $validated);
    }

    public function testValidatedPsr()
    {
        $builder = $this->builder();

        $validated = $this->url()->validated($builder);

        $this->assertInstanceOf(UriInterface::class, $validated);
        $this->assertSame($this->test_url, (string) $validated);
    }

    public function testValidate()
    {
        $this->url()->validate('https://example.com');

        $this->assertTrue(true);
    }

    public function testValidateDuplicateSlashes()
    {
        $this->url()->validate('https://example.com/foo');
        $this->url()->validate('https://example.com//foo');
        $this->url()->validate('https://example.com///foo');
        $this->url()->validate('https://example.com////foo');

        $this->assertTrue(true);
    }

    public function testValidateWithoutSchema()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "//example.com/foo" is not a valid URL.');

        $this->url()->validate('//example.com/foo');
    }

    public function testValidatePsr()
    {
        $this->url()->validate($this->builder());

        $this->assertTrue(true);
    }

    public function testValidateFailed()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        $this->url()->validate('foo.bar');
    }

    public function testDefault()
    {
        $first = 'https://github.githubassets.com/pinned-octocat.svg';

        $this->assertSame($first, $this->url()->default($first, 'https://example.com/foo.jpg'));

        $this->assertSame('https://example.com/foo.jpg', $this->url()->default('https://example.com/bar.jpg', 'https://example.com/foo.jpg'));
    }

    #[Pure]
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
