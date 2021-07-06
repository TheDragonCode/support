<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class ParseMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse('https://localhost/foo/bar');

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
        $builder = BuilderFacade::parse($this->psr_url);

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
        $builder = BuilderFacade::parse($this->psr_url, PHP_URL_HOST);

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

        $builder = BuilderFacade::parse($psr);

        $this->assertSame($this->psr_scheme, $builder->getScheme());
        $this->assertSame($this->psr_user, $builder->getUser());
        $this->assertSame($this->psr_pass, $builder->getPassword());
        $this->assertSame($this->psr_host, $builder->getHost());
        $this->assertSame($this->psr_port, $builder->getPort());
        $this->assertSame($this->psr_path, $builder->getPath());
        $this->assertSame($this->psr_query, $builder->getQuery());
        $this->assertSame($this->psr_fragment, $builder->getFragment());
    }

    public function testIncorrectUrl()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('The "foo.bar" is not a valid URL.');

        BuilderFacade::parse('foo.bar');
    }

    public function testEmpty()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        BuilderFacade::parse('');
    }

    public function testNull()
    {
        $this->expectException(NotValidUrlException::class);
        $this->expectExceptionMessage('Empty string is not a valid URL.');

        BuilderFacade::parse(null);
    }
}
