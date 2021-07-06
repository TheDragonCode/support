<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetUserInfoMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user . ':' . $this->psr_pass, $builder->getUserInfo());
    }

    public function testWithout()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertEmpty($builder->getUserInfo());
    }

    public function testOnlyUser()
    {
        $builder = BuilderFacade::parse('https://foo@example.com');

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user, $builder->getUserInfo());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getUserInfo());
        $this->assertEmpty(BuilderFacade::getUserInfo());
    }
}
