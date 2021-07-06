<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class WithPathMethodTest extends Base
{
    public function testWithoutPrefix()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getPath());
        $this->assertEmpty($builder->getPath());

        $builder->withPath('foo/bar');

        $this->assertIsString($builder->getPath());
        $this->assertSame('/foo/bar', $builder->getPath());
    }

    public function testWithPrefix()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getPath());
        $this->assertEmpty($builder->getPath());

        $builder->withPath('/foo/bar');

        $this->assertIsString($builder->getPath());
        $this->assertSame('/foo/bar', $builder->getPath());
    }

    public function testSet()
    {
        $builder = $this->builder()->parse($this->test_url);

        $builder->withPath('/foo/bar');

        $this->assertIsString($builder->getPath());
        $this->assertSame('/foo/bar', $builder->getPath());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $builder->withPath('');

        $this->assertIsString($builder->getPath());
        $this->assertEmpty($builder->getPath());
    }

    public function testNull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $builder->withPath(null);

        $this->assertIsString($builder->getPath());
        $this->assertEmpty($builder->getPath());
    }
}
