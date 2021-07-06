<?php

namespace Helldar\Support\Facades\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Filesystem\File as Helper;
use SplFileInfo;

/**
 * @method static array names(string $path, callable|null $callback = null, bool $recursive = false)
 * @method static bool ensureDelete(array|string $paths)
 * @method static bool exists(string $path)
 * @method static bool isFile(DirectoryIterator|SplFileInfo|string $value)
 * @method static string store(string $path, string $content, int $mode = 0755)
 * @method static string validated(DirectoryIterator|SplFileInfo|string $path)
 * @method static void delete(string|string[] $paths)
 * @method static void validate(DirectoryIterator|SplFileInfo|string $path)
 */
class File extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
