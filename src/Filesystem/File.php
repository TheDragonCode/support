<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Filesystem;

use DirectoryIterator;
use DragonCode\Support\Exceptions\FileNotFoundException;
use DragonCode\Support\Exceptions\FileSyntaxErrorException;
use DragonCode\Support\Exceptions\UnhandledFileExtensionException;
use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Instances\Call;
use DragonCode\Support\Facades\Instances\Instance;
use SplFileInfo;
use Throwable;

class File
{
    /**
     * Get a list of filenames with a full paths.
     *
     * @param string $path
     * @param callable|null $callback
     * @param bool $recursive
     *
     * @return array
     */
    public function allPaths(string $path, ?callable $callback = null, bool $recursive = false): array
    {
        $items = [];

        foreach (Directory::all($path) as $item) {
            if ($item->isFile()) {
                if (! is_callable($callback) || Call::callback($callback, $item->getRealPath())) {
                    $items[] = $item->getRealPath();
                }
            }

            if ($recursive && $item->isDir() && ! $item->isDot()) {
                $files = $this->allPaths($item->getRealPath(), $callback, $recursive);

                $items = array_merge($items, $files);
            }
        }

        sort($items);

        return array_values($items);
    }

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
        return Arr::of(
            $this->allPaths($path, $callback, $recursive)
        )
            ->map(fn (string $value) => Str::of($value)->after(realpath($path))->trim('\\/')->toString())
            ->toArray();
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
        Directory::ensureDirectory(Path::dirname($path), $mode);

        file_put_contents($path, $content);

        return realpath($path);
    }

    /**
     * Load content from the file.
     *
     * @param string $path
     *
     * @throws \DragonCode\Support\Exceptions\FileNotFoundException
     *
     * @return array
     */
    public function load(string $path): array
    {
        try {
            if (! $this->exists($path)) {
                throw new FileNotFoundException($path);
            }

            return match (Path::extension($path)) {
                'php'   => require $path,
                'json'  => json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR),
                default => throw new UnhandledFileExtensionException($path)
            };
        }
        catch (FileNotFoundException|UnhandledFileExtensionException $e) {
            throw $e;
        }
        catch (Throwable) {
            throw new FileSyntaxErrorException($path);
        }
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
        Directory::ensureDirectory(Path::dirname($target), $mode);

        copy($source, $target);
    }

    /**
     * Moving a file to a new path.
     *
     * @param string $source
     * @param string $target
     * @param int $mode
     *
     * @throws \DragonCode\Support\Exceptions\FileNotFoundException
     */
    public function move(string $source, string $target, int $mode = 0755): void
    {
        Directory::ensureDirectory(Path::dirname($target), $mode);

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
     * @throws \DragonCode\Support\Exceptions\FileNotFoundException
     *
     * @return void
     */
    public function delete(array|string $paths): void
    {
        foreach ((array) $paths as $path) {
            if (! $this->exists($path)) {
                throw new FileNotFoundException($path);
            }

            unlink($path);
        }
    }

    /**
     * Ensure the file has been deleted.
     *
     * @param array|string $paths
     *
     * @throws \DragonCode\Support\Exceptions\FileNotFoundException
     *
     * @return void
     */
    public function ensureDelete(array|string $paths): void
    {
        foreach ((array) $paths as $path) {
            $this->exists($path) && $this->delete($path);
        }
    }

    /**
     * Checks if an object or link is a file at the specified path.
     *
     * @param DirectoryIterator|SplFileInfo|string $value
     *
     * @return bool
     */
    public function isFile(mixed $value): bool
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
    public function validate(mixed $path): void
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
    public function validated(mixed $path): string
    {
        $this->validate($path);

        return realpath($path);
    }
}
