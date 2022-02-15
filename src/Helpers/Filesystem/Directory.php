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

namespace DragonCode\Support\Helpers\Filesystem;

use DirectoryIterator;
use DragonCode\Support\Exceptions\DirectoryNotFoundException;
use DragonCode\Support\Facades\Helpers\Filesystem\File as FileHelper;
use DragonCode\Support\Facades\Helpers\Instance;
use DragonCode\Support\Facades\Helpers\Str;
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
     * @return DirectoryIterator
     */
    public function all(string $path): DirectoryIterator
    {
        if ($this->doesntExist($path)) {
            throw new DirectoryNotFoundException($path);
        }

        return new DirectoryIterator($path);
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
    public function names(string $path, ?callable $callback = null, bool $recursive = false): array
    {
        $items = [];

        /** @var DirectoryIterator $directory */
        foreach ($this->all($path) as $directory) {
            if ($directory->isDir() && ! $directory->isDot()) {
                $name = $directory->getFilename();

                if (! is_callable($callback) || $callback($name)) {
                    $items[] = $name;
                }
            }

            if ($recursive && $directory->isDir() && ! $directory->isDot()) {
                $prefix = (string) Str::of($directory->getRealPath())
                    ->after(realpath($path))
                    ->trim('\\/');

                foreach ($this->names($directory->getRealPath(), $callback, $recursive) as $value) {
                    $items[] = $prefix . '/' . $value;
                }
            }
        }

        sort($items);

        return array_values($items);
    }

    /**
     * Create a directory at the specified path.
     *
     * @param string $path
     * @param int $mode
     *
     * @return bool
     */
    public function make(string $path, int $mode = 0755): bool
    {
        return ! $this->doesntExist($path) || mkdir($path, $mode, true);
    }

    /**
     * Delete the directory with all contents in the specified path.
     *
     * @param string $path
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (! $this->isDirectory($path)) {
            throw new DirectoryNotFoundException($path);
        }

        $items = new FilesystemIterator($path);

        $success = true;

        foreach ($items as $item) {
            $item->isDir() && ! $item->isLink()
                ? $this->delete($item->getPathname())
                : FileHelper::delete($item->getPathname());
        }

        @rmdir($path);

        return $success;
    }

    /**
     * Ensure the directory has been deleted.
     *
     * @param string $path
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     */
    public function ensureDelete(string $path): bool
    {
        return $this->doesntExist($path) || $this->delete($path);
    }

    /**
     * Ensure created directory exists.
     *
     * @param string $path
     * @param int $mode
     * @param bool $can_delete
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     */
    public function ensureDirectory(string $path, int $mode = 0755, bool $can_delete = false): void
    {
        if ($can_delete && $this->exists($path)) {
            $this->delete($path);
        }

        if ($this->doesntExist($path)) {
            $this->make($path, $mode);
        }
    }

    /**
     * Check if the directory exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool
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
    public function doesntExist(string $path): bool
    {
        return ! $this->exists($path);
    }

    /**
     * Check if object or path is a directory.
     *
     * @param DirectoryIterator|SplFileInfo|string $value
     *
     * @return bool
     */
    public function isDirectory($value): bool
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
    public function validate($path): void
    {
        if (! $this->isDirectory($path)) {
            throw new DirectoryNotFoundException($path);
        }
    }

    /**
     * Checks the existence of a directory and return full path if exist.
     *
     * @param DirectoryIterator|SplFileInfo|string $path
     *
     * @throws \DragonCode\Support\Exceptions\DirectoryNotFoundException
     *
     * @return string
     */
    public function validated($path): string
    {
        $this->validate($path);

        return realpath($path);
    }
}
