<?php

namespace Tests\Fixtures\Facades;

use Helldar\Support\Facades\Facade;

class Resolve extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'foo';
    }
}
