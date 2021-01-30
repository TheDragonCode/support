<?php

namespace Helldar\Support\Facades\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Filesystem\File as Helper;
use SplFileInfo;

/**
 * @method static bool exists(string $path)
 * @method static bool isFile(DirectoryIterator|SplFileInfo|string $value)
 * @method static void delete(string|string[] $paths)
 * @method static void store(string $path, string $content, int $mode = 0755)
 * @method static void validate(DirectoryIterator|SplFileInfo|string $path)
 */
final class File extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
