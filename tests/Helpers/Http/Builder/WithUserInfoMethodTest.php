<?php

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class WithUserInfoMethodTest extends Base
{
    public function testWith()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user . ':' . $this->psr_pass, $builder->getUserInfo());

        $builder->withUserInfo('qwe', 'rty');

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame('qwe:rty', $builder->getUserInfo());
    }

    public function testWithout()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertEmpty($builder->getUserInfo());

        $builder->withUserInfo('qwe', 'rty');

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame('qwe:rty', $builder->getUserInfo());
    }

    public function testOnlyUser()
    {
        $builder = $this->builder()->parse('https://example.com');

        $this->assertIsString($builder->getUserInfo());
        $this->assertEmpty($builder->getUserInfo());

        $builder->withUserInfo($this->psr_user);

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user, $builder->getUserInfo());
    }
}
