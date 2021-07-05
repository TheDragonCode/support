<?php

namespace Helldar\Support\Facades\Helpers\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Builder as Helper;

class Builder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
