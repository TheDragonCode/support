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
use DragonCode\Support\Exceptions\FileNotFoundException;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Filesystem\Directory as DirectoryHelper;
use DragonCode\Support\Facades\Helpers\Instance;
use DragonCode\Support\Facades\Helpers\Str;
use SplFileInfo;
use Throwable;

class File
{
    /**
     * Get a list of filenames along a path.
     *
     * @param string $path
     * @param callable|null $callback
     * @param bool $recursive
     *
     * @return array
     */
    public function names(string $path, ?callable $callback = null, bool $recursive = false): array
    {
        $items = [];

        /** @var DirectoryIterator $item */
        foreach (DirectoryHelper::all($path) as $item) {
            if ($item->isFile()) {
                $name = $item->getFilename();

                if (! is_callable($callback) || $callback($name)) {
                    $items[] = $name;
                }
            }

            if ($recursive && $item->isDir() && ! $item->isDot()) {
                $prefix = (string) Str::of($item->getRealPath())
                    ->after(realpath($path))
                    ->trim('\\/');

                foreach ($this->names($item->getRealPath(), $callback, $recursive) as $value) {
                    $items[] = $prefix . '/' . $value;
                }
            }
        }

        sort($items);

        return array_values($items);
    }

    /**
     * Save content to file.
     *
     * @param string $path
     * @param string $content
     * @param int $mode
     *
     * @return string returns the full path to the saved file
     */
    public function store(string $path, string $content, int $mode = 0755): string
    {
        DirectoryHelper::ensureDirectory(pathinfo($path, PATHINFO_DIRNAME), $mode);

        file_put_contents($path, $content);

        return realpath($path);
    }

    /**
     * Copies file.
     *
     * @param string $source
     * @param string $target
     * @param int $mode
     */
    public function copy(string $source, string $target, int $mode = 0755): void
    {
        DirectoryHelper::ensureDirectory(pathinfo($target, PATHINFO_DIRNAME), $mode);

        if ($this->exists($target)) {
            $this->delete($target);
        }

        copy($source, $target);
    }

    /**
     * Moving a file to a new path.
     *
     * @param string $source
     * @param string $target
     * @param int $mode
     */
    public function move(string $source, string $target, int $mode = 0755): void
    {
        DirectoryHelper::ensureDirectory(pathinfo($target, PATHINFO_DIRNAME), $mode);

        if ($this->exists($target)) {
            $this->delete($target);
        }

        rename($source, $target);
    }

    /**
     * Checks if the file exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function exists(string $path): bool
    {
        return file_exists($path) && is_file($path);
    }

    /**
     * Deletes files in the specified paths.
     *
     * @param string|string[] $paths
     *
     * @return bool
     */
    public function delete($paths): bool
    {
        $paths = Arr::wrap($paths);

        $success = true;

        foreach ($paths as $path) {
            try {
                if (! @unlink($path)) {
                    $success = false;
                }
            } catch (Throwable $e) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Ensure the file has been deleted.
     *
     * @param array|string $paths
     *
     * @return bool
     */
    public function ensureDelete($paths): bool
    {
        $paths = Arr::wrap($paths);

        $success = true;

        foreach ($paths as $path) {
            if ($this->exists($path) && ! $this->delete($path)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Checks if an object or link is a file at the specified path.
     *
     * @param DirectoryIterator|SplFileInfo|string $value
     *
     * @return bool
     */
    public function isFile($value): bool
    {
        if (Instance::of($value, [SplFileInfo::class, DirectoryIterator::class])) {
            return $value->isFile();
        }

        return is_file($value);
    }

    /**
     * Checks the existence of a file.
     *
     * @param DirectoryIterator|SplFileInfo|string $path
     *
     * @throws \DragonCode\Support\Exceptions\FileNotFoundException
     */
    public function validate($path): void
    {
        if (! $this->isFile($path)) {
            throw new FileNotFoundException($path);
        }
    }

    /**
     * Checks the existence of a file and return full path if exist.
     *
     * @param DirectoryIterator|SplFileInfo|string $path
     *
     * @throws \DragonCode\Support\Exceptions\FileNotFoundException
     *
     * @return string
     */
    public function validated($path): string
    {
        $this->validate($path);

        return realpath($path);
    }
}
