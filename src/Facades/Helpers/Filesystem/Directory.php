<?php

namespace Helldar\Support\Facades\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Filesystem\Directory as Helper;
use SplFileInfo;

/**
 * @method static array names(string $path)
 * @method static bool delete(string $path)
 * @method static bool doesntExist(string $path)
 * @method static bool exists(string $path)
 * @method static bool isDirectory(DirectoryIterator|SplFileInfo|string $value)
 * @method static bool make(string $path, int $mode = 0755)
 * @method static DirectoryIterator all(string $path)
 * @method static void validate(DirectoryIterator|SplFileInfo|string $path)
 */
final class Directory extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
