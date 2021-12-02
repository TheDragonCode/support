<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Facades\Helpers\Filesystem;

use DirectoryIterator;
use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Helpers\Filesystem\File as Helper;
use SplFileInfo;

/**
 * @method static array names(string $path, callable|null $callback = null, bool $recursive = false)
 * @method static bool ensureDelete(array|string $paths)
 * @method static bool exists(string $path)
 * @method static bool isFile(DirectoryIterator|SplFileInfo|string $value)
 * @method static string store(string $path, string $content, int $mode = 0755)
 * @method static string validated(DirectoryIterator|SplFileInfo|string $path)
 * @method static void copy(string $source, string $target, int $mode = 0755)
 * @method static void delete(string|string[] $paths)
 * @method static void move(string $source, string $target, int $mode = 0755)
 * @method static void validate(DirectoryIterator|SplFileInfo|string $path)
 */
class File extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
