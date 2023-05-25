<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Filesystem;

use DirectoryIterator;
use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Exceptions\InvalidDestinationPathException;
use DragonCode\Support\Helpers\Arr;
use DragonCode\Support\Helpers\Str;
use DragonCode\Support\Instances\Call;
use DragonCode\Support\Instances\Instance;
use FilesystemIterator;
use SplFileInfo;

class Directory
{
    /**
     * Get a list of files and folders in a directory.
     *
     * @param string $path
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return \DirectoryIterator
     */
    public static function all(string $path): DirectoryIterator
    {
        if (static::doesntExist($path)) {
            throw new DirectoryNotFoundException($path);
        }

        return new DirectoryIterator($path);
    }

    /**
     * Get a list of directory paths.
     *
     * @param string $path
     * @param callable|null $callback
     * @param bool $recursive
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return array
     */
    public static function paths(string $path, ?callable $callback = null, bool $recursive = true): array
    {
        $items = [];

        foreach (static::all($path) as $directory) {
            if ($directory->isDot() || ! $directory->isDir()) {
                continue;
            }

            if (is_null($callback) || Call::callback($callback, $directory->getRealPath())) {
                $items[] = $directory->getRealPath();
            }

            if ($recursive) {
                $items += static::paths($directory->getRealPath(), $callback, $recursive);
            }
        }

        return array_values($items);
    }

    /**
     * Get a list of directory names along a path.
     *
     * @param string $path
     * @param callable|null $callback
     * @param bool $recursive
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return array
     */
    public static function names(string $path, ?callable $callback = null, bool $recursive = true): array
    {
        return Arr::of(
            static::paths($path, $callback, $recursive)
        )
            ->map(fn (string $value) => Str::of($value)->after(realpath($path))->trim('\\/')->toString())
            ->toArray();
    }

    /**
     * Create a directory at the specified path.
     *
     * @param string $path
     * @param int $mode
     *
     * @return bool
     */
    public static function make(string $path, int $mode = 0755): bool
    {
        return static::exists($path) || mkdir($path, $mode, true);
    }

    /**
     * Copies directory.
     *
     * @param string $source
     * @param string $target
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     * @throws \DragonCode\Support\Exceptions\InvalidDestinationPathException
     *
     * @return void
     */
    public static function copy(string $source, string $target): void
    {
        static::validate($source);
        static::comparePaths($source, $target);
        static::ensureDirectory($target);

        foreach (File::names($source, recursive: true) as $file) {
            File::copy(
                $source . '/' . $file,
                $target . '/' . $file
            );
        }
    }

    /**
     * Moving a directory to a new path.
     *
     * @param string $source
     * @param string $target
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     * @throws \DragonCode\Support\Exceptions\InvalidDestinationPathException
     *
     * @return void
     */
    public static function move(string $source, string $target): void
    {
        static::copy($source, $target);

        static::ensureDelete($source);
    }

    /**
     * Delete the directory with all contents in the specified path.
     *
     * @param array|string $paths
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return void
     */
    public static function delete(array|string $paths): void
    {
        foreach ((array) $paths as $path) {
            if (! static::isDirectory($path)) {
                throw new DirectoryNotFoundException($path);
            }

            $items = new FilesystemIterator($path);

            foreach ($items as $item) {
                $item->isDir() && ! $item->isLink()
                    ? static::delete($item->getPathname())
                    : File::delete($item->getPathname());
            }

            @rmdir($path);
        }
    }

    /**
     * Ensure the directory has been deleted.
     *
     * @param array|string $paths
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return void
     */
    public static function ensureDelete(array|string $paths): void
    {
        foreach ((array) $paths as $path) {
            static::doesntExist($path) || static::delete($path);
        }
    }

    /**
     * Ensure created directory exists.
     *
     * @param string $path
     * @param int $mode
     */
    public static function ensureDirectory(string $path, int $mode = 0755): void
    {
        if (static::doesntExist($path)) {
            static::make($path, $mode);
        }
    }

    /**
     * Check if the directory exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function exists(string $path): bool
    {
        return file_exists($path) && is_dir($path);
    }

    /**
     * Check if the directory doesn't exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function doesntExist(string $path): bool
    {
        return ! static::exists($path);
    }

    /**
     * Check if object or path is a directory.
     *
     * @param DirectoryIterator|SplFileInfo|string $value
     *
     * @return bool
     */
    public static function isDirectory(mixed $value): bool
    {
        if (Instance::of($value, [SplFileInfo::class, DirectoryIterator::class])) {
            return $value->isDir();
        }

        return is_dir($value);
    }

    /**
     * Checks the existence of a directory.
     *
     * @param DirectoryIterator|SplFileInfo|string $path
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     */
    public static function validate(DirectoryIterator|SplFileInfo|string $path): void
    {
        if (! static::isDirectory($path)) {
            throw new DirectoryNotFoundException($path);
        }
    }

    /**
     * Checks the existence of a directory and return full path if exists.
     *
     * @param \DirectoryIterator|\SplFileInfo|string $path
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     * @return string
     */
    public static function validated(DirectoryIterator|SplFileInfo|string $path): string
    {
        static::validate($path);

        return realpath($path);
    }

    /**
     * Comparison of start and end paths.
     *
     * @param string $path1
     * @param string $path2
     *
     * @throws \DragonCode\Support\Exceptions\InvalidDestinationPathException
     *
     * @return void
     */
    protected static function comparePaths(string $path1, string $path2): void
    {
        if ($path1 === $path2 || realpath($path1) === realpath($path2)) {
            throw new InvalidDestinationPathException(realpath($path1));
        }
    }
}
