<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetAuthorityMethodTest extends Base
{
    public function testUserPassword()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo:bar@en.example.com:8901', $builder->getAuthority());
    }

    public function testUser()
    {
        $builder = BuilderFacade::parse('https://foo@example.com:8901');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo@example.com:8901', $builder->getAuthority());
    }

    public function testFullWithoutPort()
    {
        $builder = BuilderFacade::parse('https://foo:bar@example.com');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo:bar@example.com', $builder->getAuthority());
    }

    public function testUserWithoutPort()
    {
        $builder = BuilderFacade::parse('https://foo@example.com');

        $this->assertIsString($builder->getAuthority());
        $this->assertSame('foo@example.com', $builder->getAuthority());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getAuthority());
        $this->assertEmpty(BuilderFacade::getAuthority());
    }
}
