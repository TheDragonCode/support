<?php

declare(strict_types=1);

namespace DragonCode\Support\Facades\Helpers;

use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Helpers\Version as Helper;

/**
 * @method static Helper of(string $version)
 * @method static bool eq(string $version)
 * @method static bool equalTo(string $version)
 * @method static bool greaterThan(string $version)
 * @method static bool greaterThanOrEqualTo(string $version)
 * @method static bool gt(string $version)
 * @method static bool gte(string $version)
 * @method static bool lessThan(string $version)
 * @method static bool lessThanOrEqualTo(string $version)
 * @method static bool lt(string $version)
 * @method static bool lte(string $version)
 * @method static bool ne(string $version)
 * @method static bool notEqualTo(string $version)
 */
class Version extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
