<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class RemoveFragmentMethodTest extends Base
{
    public function testEmpty()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getFragment());
        $this->assertEmpty($builder->getFragment());

        $builder->removeFragment();

        $this->assertIsString($builder->getFragment());
        $this->assertEmpty($builder->getFragment());
    }

    public function testRemove()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getFragment());
        $this->assertEmpty($builder->getFragment());

        $builder->withFragment($this->psr_fragment);

        $this->assertIsString($builder->getFragment());
        $this->assertSame($this->psr_fragment, $builder->getFragment());

        $builder->removeFragment();

        $this->assertIsString($builder->getFragment());
        $this->assertEmpty($builder->getFragment());
    }
}