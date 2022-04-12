<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Exceptions\NotValidUrlException;
use DragonCode\Support\Exceptions\UnknownUrlComponentIndexException;
use DragonCode\Support\Facades\Http\Builder;

class ParseMethodTest extends Base
{
    public function testShort()
    {
        $builder = Builder::parse('https://localhost/foo/bar');

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('localhost', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());

        $this->assertNull($builder->getPort());

        $this->assertEmpty($builder->getUser());
        $this->assertEmpty($builder->getQuery());
        $this->assertEmpty($builder->getPassword());
        $this->assertEmpty($builder->getFragment());

        $this->assertIsString($builder->getUser());
        $this->assertIsString($builder->getQuery());
        $this->assertIsString($builder->getPassword());
        $this->assertIsString($builder->getFragment());
    }

    public function testFull()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertSame($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_user, $builder->getUser());
        $this->assertSame($this->psr_pass, $builder->getPassword());
        $this->assertSame($this->psr_host, $builder->getHost());
        $this->assertSame($this->psr_port, $builder->getPort());
        $this->assertSame($this->psr_path, $builder->getPath());
        $this->assertSame($this->psr_query, $builder->getQuery());
        $this->assertSame($this->psr_fragment, $builder->getFragment());
    }

    public function testComponent()
    {
        $builder = Builder::parse($this->psr_url, PHP_URL_HOST);

        $this->assertSame($this->psr_host, $builder->getHost());

        $this->assertEmpty($builder->getScheme());
        $this->assertEmpty($builder->getUser());
        $this->assertEmpty($builder->getPassword());
        $this->assertEmpty($builder->getPath());
        $this->assertEmpty($builder->getQuery());
        $this->assertEmpty($builder->getFragment());

        $this->assertNull($builder->getPort());
    }

    public function testPsr()
    {
        $psr = $this->psr();

        $builder = Builder::parse($psr);

        $this->assertSame($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_user, $builder->getUser());
        $this->assertSame($this->psr_pass, $builder->getPassword());
        $this->assertSame($this->psr_host, $builder->getHost());
        $this->assertSame($this->psr_port, $builder->getPort());
        $this->assertSame($this->psr_path, $builder->getPath());
        $this->assertSame($this->psr_query, $builder->getQuery());
        $this->assertSame($this->psr_fragment, $builder->getFragment());
    }

    public function testDoubleSlashes()
    {
        $url = 'https://example.com//foo/bar?id=123#qwerty';

        $builder = Builder::parse($url);

        $this->assertSame('https', $builder->getScheme());
        $this->assertSame('example.com', $builder->getHost());
        $this->assertSame('/foo/bar', $builder->getPath());
        $this->assertSame('id=123', $builder->getQuery());
        $this->assertSame('qwerty', $builder->getFragment());

        $this->assertEmpty($builder->getUser());
        $this->assertEmpty($builder->getPassword());
        $this->assertEmpty($builder->getPort());
    }

    public function testDoubleCallingToSame()
    {
        $first  = Builder::parse('https://foo.example.com/foo');
        $second = Builder::parse('http://bar.example.com/bar');

        $this->assertSame('https', $first->getScheme());
        $this->assertSame('foo.example.com', $first->getHost());
        $this->assertSame('/foo', $first->getPath());

        $this->assertSame('http', $second->getScheme());
        $this->assertSame('bar.example.com', $second->getHost());
        $this->assertSame('/bar', $second->getPath());
    }

    public function testDoubleCallingToDiff()
    {
        $first  = Builder::parse('https://foo.example.com/foo');
        $second = Builder::parse('http://bar.example.com/bar');

        $this->assertSame('https', $first->getScheme());
        $this->assertSame('foo.example.com', $first->getHost());
        $this->assertSame('/foo', $first->getPath());

        $this->assertSame('http', $second->getScheme());
        $this->assertSame('bar.example.com', $second->getHost());
        $this->assertSame('/bar', $second->getPath());
    }

    public function testComponents()
    {
        $builder = Builder::same()
            ->parse('https://example.com')
            ->parse($this->psr_url, PHP_URL_SCHEME)
            ->parse($this->psr_url, PHP_URL_HOST)
            ->parse($this->psr_url, PHP_URL_PATH);

        $this->assertSame($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_host, $builder->getHost());
        $this->assertSame($this->psr_path, $builder->getPath());

        $this->assertEmpty($builder->getPort());
        $this->assertEmpty($builder->getUser());
        $this->assertEmpty($builder->getPassword());
        $this->assertEmpty($builder->getQuery());
        $this->assertEmpty($builder->getFragment());
    }

    public function testIncorrectUrl()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        Builder::parse('foo.bar');
    }

    public function testEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        Builder::parse('');
    }

    public function testNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        Builder::parse(null);
    }

    public function testUnknownComponent()
    {
        $this->expectException(UnknownUrlComponentIndexException::class);
        $this->expectExceptionMessage('Unknown URL component index: 9999');

        Builder::parse($this->test_url, 9999);
    }
}
