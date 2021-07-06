<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class GetUserInfoMethodTest extends Base
{
    public function testWith()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user . ':' . $this->psr_pass, $builder->getUserInfo());
    }

    public function testWithout()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertEmpty($builder->getUserInfo());
    }

    public function testOnlyUser()
    {
        $builder = $this->builder()->parse('https://foo@example.com');

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user, $builder->getUserInfo());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getUserInfo());
        $this->assertEmpty($builder->getUserInfo());
    }
}
