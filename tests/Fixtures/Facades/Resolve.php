<?php

namespace Tests\Fixtures\Facades;

use Helldar\Support\Facades\BaseFacade;

class Resolve extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return 'foo';
    }
}
