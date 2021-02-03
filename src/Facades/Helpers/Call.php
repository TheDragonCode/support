<?php

namespace Helldar\Support\Facades\Helpers;

use Closure;
use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Call as Helper;

/**
 * @method static mixed|null run(callable|Closure|string $class, string $method, ...$parameters)
 * @method static mixed|null runExists(callable|Closure|string $class, string $method, ...$parameters)
 * @method static mixed|null runMethods($class, $methods, ...$parameters)
 * @method static mixed|null runOf(array $map, $value, ...$parameters)
 * @method static mixed|null when(bool $when, callable|Closure|string $class, string $method, ...$parameters)
 */
final class Call extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
