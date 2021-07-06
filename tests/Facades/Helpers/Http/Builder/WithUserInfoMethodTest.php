<?php

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithUserInfoMethodTest extends Base
{
    public function testFull()
    {
        $this->assertIsString(BuilderFacade::withUserInfo($this->psr_user, $this->psr_pass)->getUserInfo());
        $this->assertSame($this->psr_user . ':' . $this->psr_pass, BuilderFacade::withUserInfo($this->psr_user, $this->psr_pass)->getUserInfo());
    }

    public function testOnlyUser()
    {
        $this->assertIsString(BuilderFacade::withUserInfo($this->psr_user)->getUserInfo());
        $this->assertSame($this->psr_user, BuilderFacade::withUserInfo($this->psr_user)->getUserInfo());
    }
}
