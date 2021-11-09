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
use DragonCode\Support\Helpers\Filesystem\Directory as Helper;
use SplFileInfo;

/**
 * @method static array names(string $path, callable|null $callback = null, bool $recursive = false)
 * @method static bool delete(string $path)
 * @method static bool doesntExist(string $path)
 * @method static bool ensureDelete(string $path)
 * @method static bool exists(string $path)
 * @method static bool isDirectory(DirectoryIterator|SplFileInfo|string $value)
 * @method static bool make(string $path, int $mode = 0755)
 * @method static DirectoryIterator all(string $path)
 * @method static string validated(DirectoryIterator|SplFileInfo|string $path)
 * @method static void ensureDirectory(string $path, int $mode = 0755, bool $can_delete = false)
 * @method static void validate(DirectoryIterator|SplFileInfo|string $path)
 */
class Directory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
