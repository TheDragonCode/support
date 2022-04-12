<?php

namespace DragonCode\Support\Facades\Filesystem;

use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Filesystem\Path as Helper;

/**
 * @method static string basename(string $path)
 * @method static string dirname(string $path)
 * @method static string extension(string $path)
 * @method static string filename(string $path)
 */
class Path extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
