<?php

namespace Helldar\Support\Helpers\Filesystem;

use DirectoryIterator;
use FilesystemIterator;
use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\File as FileHelper;
use Helldar\Support\Facades\Helpers\Instance;
use SplFileInfo;

final class Directory
{
    /**
     * Get a list of files and folders in a directory.
     *
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
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
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     *
     * @return array
     */
    public function names(string $path): array
    {
        $items = [];

        foreach ($this->all($path) as $directory) {
            if ($directory->isDir() && ! $directory->isDot()) {
                $items[] = $directory->getFilename();
            }
        }

        sort($items);

        return array_values($items);
    }

    /**
     * Create a directory at the specified path.
     *
     * @param  string  $path
     * @param  int  $mode
     *
     * @return bool
     */
    public function make(string $path, int $mode = 755): bool
    {
        return $this->doesntExist($path) ? mkdir($path, $mode, true) : true;
    }

    /**
     * Delete the directory with all contents in the specified path.
     *
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
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
     * Check if the directory exists.
     *
     * @param  string  $path
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
     * @param  string  $path
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
     * @param  DirectoryIterator|\SplFileInfo|string  $value
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
     * @param  DirectoryIterator|\SplFileInfo|string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     */
    public function validate($path): void
    {
        if (! $this->isDirectory($path)) {
            throw new DirectoryNotFoundException($path);
        }
    }
}
