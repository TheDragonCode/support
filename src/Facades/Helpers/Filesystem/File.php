<?php

namespace Helldar\Support\Facades\Helpers\Filesystem;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Filesystem\File as Helper;

/**
 * @method static bool exists(string $path)
 * @method static void delete(string|string[] $paths)
 * @method static void store(string $path, string $content)
 */
final class File extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
