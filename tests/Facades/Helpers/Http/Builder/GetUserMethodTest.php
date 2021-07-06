<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetUserMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getUser());
        $this->assertSame($this->psr_user, $builder->getUser());
    }

    public function testWithout()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getUser());
        $this->assertEmpty($builder->getUser());
    }

    public function testOnlyUser()
    {
        $builder = BuilderFacade::parse('https://foo@example.com');

        $this->assertIsString($builder->getUser());
        $this->assertSame($this->psr_user, $builder->getUser());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getUser());
        $this->assertEmpty(BuilderFacade::getUser());
    }
}
